<?php

/**
 * abstract facotry Response Creator
 */

namespace App\Services\Response;

use Symfony\Component\HttpFoundation\Response;

interface ResponseCreatorInterface
{
  /**
   * create Response method
   * @return Response [description]
   */
  public function createResponse($context, int $status): Response;
}
