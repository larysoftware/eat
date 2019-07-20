<?php
/**
 * @author l.surdy lukasz7221@gmail.com
 * Interface dla kontrollera API
 */

namespace App\ApiController;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

interface ControllerInterface
{


 public function setManager();

 /**
  * get Etity Repository
  *
  * @return RepositoryInterface
  */
 public function getRepository(): ?ServiceEntityRepository;


 /**
  * return not found response
  *
  * @return JsonResponse not found
  */
 public function createNotFoundResponse(): JsonResponse;


 /**
  * return delete
  *
  * @return JsonResponse [description]
  */
 public function deleteOkResponse(): JsonResponse;


 /**
  * delete error
  * @return JsonResponse [description]
  */
 public function deleteErrorResponse(): JsonResponse;


 /**
  * create
  * @param  mixed $resource
  * @param  int $status
  * @return JsonResponse
  */
 public function createResponse($resource, int $status = Response::HTTP_CREATED): JsonResponse;

 /**
  * seriaize resource to json
  * @param  [type]       $resource [description]
  * @param  [type]       $status   [description]
  * @return JsonResponse           [description]
  */
 public function createResourceResponse($resource, int $status = Response::HTTP_OK): JsonResponse;


 /**
  * zwraca liste z encjami po paginacji
  * @param  Request $request [description]
  * @return array            [description]
  */
 public function createList(Request $request): JsonResponse;

}
