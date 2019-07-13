<?php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AbstractRepository;

/**
 *  lukasz7221@gmail.com
 *
 * AbstractController for Rest Api
 */
abstract class AbstractController extends Controller
{

  protected $entity;

  /**
   * Entity
   * @var EntityManagerInterface
   */
  protected $entityManager;

  /**
   * [protected description]
   * @var AbstractRepository
   */
  protected $repository;

  /**
   * entity class
   * @param string entity name class
   */
  public function __construct(string $entity)
  {
    $this -> entity = $entity;
  }

  /**
   * @required
   */
  public function setManager()
  {
    $this -> entityManager = $this -> getDoctrine() -> getManager();
  }


  /**
   * get Etity Repository
   *
   * @return RepositoryInterface
   */
  public function getRepository() : ?RepositoryInterface
  {
    return $this -> entityManager -> getRepository($this -> entity);
  }

}
