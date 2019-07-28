<?php

/**
 * @author lukasz7221@gmail.com
 *
 */

namespace App\ApiController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use App\Repository\AbstractRepository;
use App\Services\Response\JsonResponseFactory;
use App\Services\Paginator\Paginator;

abstract class AbstractController extends Controller
{


  public const DELETED = [
    'success' => 'Deleted.'
  ];

  public const NOT_FOUND = [
    'error' => 'Resource not found.'
  ];

  public const GENERAL_ERROR = [
    'error' => 'Something went wrong.'
  ];

  public const DELETED_NO_CONTENT = [
    'error' =>'No content'
  ];

  protected $entity;

  /**
   * Entity
   * @var EntityManagerInterface
   */
  protected $entityManager;

  /**
   * [protected description]
   * @var AbstractRepository
   */
  protected $repository;

  /**
   * @var JsonResponseFactory
   */
  protected $responseFactory;

  /**
   * @var ValidationManager
   */
  protected $validatorManager;

  /**
   * entity class
   * @param string entity name class
   */
  public function __construct(string $entity)
  {
    $this -> entity = $entity;
  }

  /**
   * @required
   */
  public function setManager()
  {
    $this -> entityManager = $this -> getDoctrine() -> getManager();
  }

  /**
   * @required
   * @param JsonResponseFactory $responseFactory [description]
   */
  public function setResponseFactory(JsonResponseFactory $responseFactory)
  {
    $this -> responseFactory = $responseFactory;
  }


  /**
   * get Etity Repository
   *
   * @return RepositoryInterface
   */
  public function getRepository() : ?ServiceEntityRepository
  {
    return $this -> entityManager -> getRepository($this -> entity);
  }

  /**
   * return not found response
   *
   * @return JsonResponse not found
   */
  public function createNotFoundResponse(): JsonResponse
  {

    return new JsonResponse(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
  }


  /**
   * return delete
   *
   * @return JsonResponse [description]
   */
  public function deleteOkResponse(): JsonResponse
  {

    return new JsonResponse(self::DELETED, Response::HTTP_OK);
  }


  /**
   * delete error
   * @return JsonResponse [description]
   */
  public function deleteErrorResponse(): JsonResponse
  {
    return new JsonResponse(self::DELETED_NO_CONTENT, Response::HTTP_NO_CONTENT);
  }

  /**
   * create
   * @param  mixed $resource
   * @param  int $status
   * @return JsonResponse
   */
  public function createResponse($resource, int $status = Response::HTTP_CREATED): JsonResponse
  {
    return $this -> createResourceResponse($resource, $status);
  }


  /**
   * helper
   * return error form
   * @param  FormInterface $form [description]
   * @return array               [description]
   */
  public function getErrorsFromForm(FormInterface $form) : array
  {
    $errors = [];
    foreach ($form -> getErrors() as $error) {
      $errors[] = $error->getMessage();
    }

    foreach ($form -> all() as $childForm) {
      if ($childForm instanceof FormInterface) {
        if($childErrors = $this -> getErrorsFromForm($childForm)) {
          $errors[$childForm -> getName()] = $childErrors;
        }
      }
    }

    return $errors;
  }

  /**
   * Validation error response
   * @param  array $resource error list
   * @return JsonResponse           [description]
   */
  public function createValidationErrorResponse(array $resource): JsonResponse
  {
    return $this -> createResourceResponse([
      'message' => 'Validation Failed',
      'errors' => $resource
    ], Response::HTTP_BAD_REQUEST);
  }

  /**
   * seriaize resource
   * @param  [type]       $resource [description]
   * @param  [type]       $status   [description]
   * @return JsonResponse           [description]
   */
  public function createResourceResponse($resource, int $status = Response::HTTP_OK): JsonResponse
  {
    return $this -> responseFactory
    -> createResponse($resource, $status);
  }

  /**
   * metoda wytworcza paginatora
   * @param  Request   $request [description]
   * @param  int       $limit   [description]
   * @param  int       $page    [description]
   * @return Paginator          [description]
   */
  public function createPaginator(int $length, int $limit, int $page): Paginator
  {
    $limit = (($limit > 0 && $limit < 100) ? $limit: 10);

    return new Paginator($length, $limit, $page);
  }

  /**
   * zwraca liste z encjami
   * @param  array        $query [description]
   * @param  int          $limit [description]
   * @param  int          $page  [description]
   * @param  array        $order [description]
   * @return JsonResponse        [description]
   */
  public function createList(array $query, int $limit, int $page, array $order = [], $code = Response::HTTP_OK): JsonResponse
  {
    try{

      $repository = $this -> getRepository();

      #zliczam dane z repozytorium
      $length = (int)$repository -> count($query);

      #tworze paginator
      $paginagor = $this -> createPaginator($length, $limit, $page);

      #waliduje dane z paginatora
      if($paginagor -> validate() == false) {
        return $this -> createNotFoundResponse();
      }


      # zwracam dane po paginacji
      $aResults = $repository -> findBy(
        $query,
        $order,
        $paginagor -> getLimit(),
        $paginagor -> getFirstResult()
      );

      return $this
      -> responseFactory
      -> createList($aResults, $paginagor, $code);

    }catch(\Exception $e) {

      /* return exception */
      return $this -> createValidationErrorResponse(
        [
          $e -> getMessage()
        ]
      );

    }

  }

}
