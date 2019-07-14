<?php
/**
 * @author l.surdy lukasz7221@gmail.com
 * Interface dla kontrollera API
 */

namespace App\ApiController;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
  * seriaize resource to json
  * @param  [type]       $resource [description]
  * @param  [type]       $status   [description]
  * @return JsonResponse           [description]
  */
 public function createResourceResponse($resource, $status = Response::HTTP_OK): JsonResponse;


}
