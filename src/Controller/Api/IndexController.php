<?php

namespace App\Controller\Api;

use App\ApiController\AbstractController;
use App\ApiController\ControllerInterface;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Entity\Customers;

/**
 * @Route(path="/api")
 */
class IndexController extends AbstractController implements ControllerInterface
{

    public function __construct()
    {
      parent::__construct(Customers::class);
    }

    /**
     * @Route(name="index", methods="GET")
     * @SWG\Tag(name="Customers")
     * @SWG\Response(
     *  response=200,
     *  description="sdsd",
     *  @SWG\Schema(
     *    type="array",
     *    @SWG\Items(ref=@Model(type=Customers::class))
     *  )
     * )
     *
     */
    public function index() : JsonResponse
    {

      return $this -> createNotFoundResponse();
    }
}
