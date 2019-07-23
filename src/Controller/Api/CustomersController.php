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

use App\ConstraintsBuilders\CustomerRegister;

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
     * @Route("/{customer}", name="customers", methods="GET", requirements={"customer":"\d+"})
     */
    public function index(?Customers $customer): JsonResponse
    {

      if($customer === null) {
        return $this -> createNotFoundResponse();
      }

      return $this -> createResourceResponse($customer);
    }

    /**
     * @Route("/", name="customers_create", methods="POST")
     * @param  Request      $request [description]
     * @return JsonResponse          [description]
     */
    public function post(Request $request): JsonResponse
    {

      if(false == $this -> validate(new CustomerRegister, $request -> request -> all())) {

        return $this -> createValidationErrorResponse(
          $this -> getLastErrors()
        );
      }

      return $this -> createResourceResponse();
    }


    /**
     * @Route("/", name="customers_find", methods="GET")
     * @return JsonResponse [description]
     */
    public function findBy(Request $request): JsonResponse
    {

      $query = $request -> query;
      $limit = (int)$query -> get('limit', 1);
      $page = (int)$query -> get('page', 1);

      $query -> remove('limit');
      $query -> remove('page');

      $query = $request -> query -> all();

      return $this -> createList($query, $limit, $page);
    }
}
