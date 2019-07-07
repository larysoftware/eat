<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index() : JsonResponse
    {

        $response = new JsonResponse([
            'interesting' => 'ok'
        ]);

        $response -> setStatusCode(JsonResponse::HTTP_OK);
        return $response;
    }
}
