<?php

namespace App\Controller\Api;

use App\ApiController\AbstractController;
use App\ApiController\ControllerInterface;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Customers;
use App\Services\Customers\CustomersService;

/**
 * @Route(path="/api/customers")
 */
class CustomersController extends AbstractController implements ControllerInterface
{

    public function __construct()
    {
      parent::__construct(Customers::class);
    }

    /**
     * @Route("/{customer}", name="index", methods="GET", requirements={"customer":"\d+"})
     */
    public function index(?Customers $customer): JsonResponse
    {

      if($customer === null) {
        return $this -> createNotFoundResponse();
      }

      return $this -> createResourceResponse($customer);
    }

    /**
     * @Route("/", name="find", methods="GET")
     * @return JsonResponse [description]
     */
    public function findBy(Request $request): JsonResponse
    {
      return $this -> createList($request);
    }
}
