<?php

/**
 * abstract facotry Response Creator
 */

namespace App\Services\Response;

use Symfony\Component\HttpFoundation\Response;

use App\Services\Paginator\Paginator;

interface ResponseCreatorInterface
{
  /**
   * create Response method
   * @return Response [description]
   */
  public function createResponse($context, int $status): Response;

  /**
   * tworzy structure odpowiedzi
   * @param  array     $aResults  [description]
   * @param  Paginator $paginagor [description]
   * @param  [type]    $code      [description]
   * @return Response             [description]
   */
  public function createList(array $aResults, Paginator $paginagor, int $code): Response;
}
