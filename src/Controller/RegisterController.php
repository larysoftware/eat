<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Customers\FactoryInterface as CustomersFactory;


class RegisterController extends AbstractController
{

    protected $customerFactory;

    public function __construct(CustomersFactory $cf)
    {
      $this -> customerFactory = $cf;
    }

    /**
     * @Route("/api/register", name="register", methods="POST")
     */
    public function register(Request $request)
    {

      $data = $request -> getAll();

      if( ($customer = $this -> customerFactory -> registerCustomer($data)) ) {

        return $this -> json([
        ]);

      }

      return $this->json();
    }
}
