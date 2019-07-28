<?php

#dekorator rozszerzajacy zapytania dla repozytorium
namespace App\Services\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class RepositoryDecorator {

  protected $repository;

  public function __construct(ServiceEntityRepository $repository)
  {
    $this -> repository = $repository;
  }

  public function count(array $query = []): int
  {
    return $this -> repository -> count($query);
  }

  /**
   * @todo
   * @param  array $query       [description]
   * @param  array $order       [description]
   * @param  ?int  $limit       [description]
   * @param  ?int  $firstResult [description]
   * @param  array $filter      [description]
   * @return array              [description]
   */
  public function findBy(array $query, array $order = [], ?int $limit, ?int $firstResult, array $filter): array
  {

    array_walk($filter, function(&$val){
      $val = 'q.' . $val;
    });

    $q = $this -> repository
    -> createQueryBuilder('q');

    $q-> select($filter)
    -> setFirstResult($firstResult)
    -> setMaxResults($limit);


    foreach ($query as $name => $value) {
      $q -> setParameter($name, $value);
      $q -> andWhere("q.$name = :$name");
    }

    return $q -> getQuery()
    -> getResult();
  }

}
