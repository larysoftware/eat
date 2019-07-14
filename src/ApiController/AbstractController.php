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

abstract class AbstractController extends Controller
{


  public const DELETED = ['success' => 'Deleted.'];
  public const NOT_FOUND = ['error' => 'Resource not found.'];
  public const GENERAL_ERROR = ['error' => 'Something went wrong.'];

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
   * seriaize resource
   * @param  [type]       $resource [description]
   * @param  [type]       $status   [description]
   * @return JsonResponse           [description]
   */
  public function createResourceResponse($resource, $status = Response::HTTP_OK): JsonResponse
  {

    return new JsonResponse([

    ], $status);
  }


}
