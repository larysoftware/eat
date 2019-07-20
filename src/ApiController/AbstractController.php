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
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AbstractRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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


  protected $responseFactory;

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
   * zwraca liste z encjami po paginacji
   * @param  Request $request [description]
   * @return array            [description]
   */
  public function createList(Request $request): JsonResponse
  {
    $repository = $this -> getRepository();
    $data = $request -> query -> all();
    $limit = 10;
    $page = 1;
    # usuwam zbedne informacje
    if(isset($data['limit'])){
      $limit = (int)$data['limit'];
      unset($data['limit']);
    }

    if(isset($data['page'])){
      $page = (int)$data['page'];
      unset($data['page']);
    }

    #zliczam dane z repozytorium
    $length = (int)$repository -> count($data);

    #
    $paginagor = $this -> createPaginator($length, $limit, $page);

    $aData = $repository -> findBy(
      $data,
      ['id' => 'DESC'],
      $paginagor -> getLimit(),
      $paginagor -> getFirstResult()
    );

    if(is_array($aData) == false || count($aData) == 0 ){
      return $this -> createNotFoundResponse();
    }

    return $this -> createResourceResponse([
      'currentPage' => $paginagor -> getCurrentPage(),
      'limit' => $paginagor -> getLimit(),
      'maxPages' => $paginagor -> getMaxPage(),
      'nResult' => $paginagor -> getNResult(),
      'data' => $aData
    ]);

  }

}
