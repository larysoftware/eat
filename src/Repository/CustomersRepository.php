<?php

namespace App\Repository;

use App\Entity\Customers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Services\Customers\CustomersStorageInterface;
use App\Services\Customers\CustomersInterface;

/**
 * @method Customers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customers[]    findAll()
 * @method Customers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomersRepository extends ServiceEntityRepository implements CustomersStorageInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customers::class);
    }

    /**
     * zwraca jednego klienta
     * @param  array              $query [description]
     * @return CustomersInterface        [description]
     */
    public function findOneByQuery(array $query): CustomersInterface
    {
      return new Customers;
    }

    /**
     * usuwa
     * @param  int    $id [description]
     * @throws \Exception
     */
    public function delete(CustomersInterface $customer)
    {
      $em = $this -> getEntityManager();

      $em -> remove($customer);
      $em -> flush();
    }

    /**
     * aktualizuje klienta
     * @param  CustomersInterface $customer
     * @throws \Exception
     */
    public function update(CustomersInterface $customer)
    {
      $em = $this -> getEntityManager();

      $em -> persist($customer);
      $em -> flush();
    }

    /**
     * create
     * @param  CustomersInterface $customer [description]
     * @throws \Exception
     */
    public function create(CustomersInterface $customer)
    {
      $em = $this -> getEntityManager();

      $em -> persist($customer);
      $em -> flush();
    }

}
