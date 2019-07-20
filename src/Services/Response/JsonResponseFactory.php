<?php
namespace App\Services\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerBuilder;

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
}
