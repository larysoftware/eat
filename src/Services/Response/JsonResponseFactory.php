<?php
namespace App\Services\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerBuilder;
use App\Services\Paginator\Paginator;

class JsonResponseFactory implements ResponseCreatorInterface
{

    protected $serializer;

    protected $response;

    public function __construct()
    {
        $this -> serializer = SerializerBuilder::create() -> build();
        $this -> response = new JsonResponse;
    }

  /**
   * create Response method
   * @return Response [description]
   */
   public function createResponse($context, int $code): Response
   {

     $jsonContent = $this -> serializer -> serialize($context, 'json');
     $this -> response -> setContent($jsonContent);
     $this -> response -> setStatusCode($code);

     return $this -> response;
   }

   /**
    * tworzy structure odpowiedzi
    * @param  array     $aResults  [description]
    * @param  Paginator $paginagor [description]
    * @param  [type]    $code      [description]
    * @return Response             [description]
    */
   public function createList(array $aResults, Paginator $paginagor, int $code): Response
   {

     return $this -> createResponse([
       'currentPage' => $paginagor -> getCurrentPage(),
       'limit' => $paginagor -> getLimit(),
       'maxPages' => $paginagor -> getMaxPage(),
       'nResult' => $paginagor -> getNResult(),
       'results' => $aResults
     ], $code);
   }
}
