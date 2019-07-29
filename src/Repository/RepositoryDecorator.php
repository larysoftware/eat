<?php

#dekorator rozszerzajacy zapytania dla repozytorium
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class RepositoryDecorator {

  protected const ALIAS = 'query';

  protected $repository;

  /**
   * przygotwuje filtry do selecta
   * @param  array $filter filters
   * @return array $selectResult
   */
  protected function preparFilterToSelect(array $filter): array
  {

    if(count($filter) == 0) {
      return [];
    }

    array_walk($filter, function(&$val){
      $val = self::ALIAS . '.' . $val;
    });

    return $filter;
  }

  public function __construct(ServiceEntityRepository $repository)
  {
    $this -> repository = $repository;
  }

  /**
   * wzbogaca metode o parametr filter, dzieki czemu mozliwe
   * jest wybranie pol ktore wyswietla zapytanie
   * @param  array $query       condition
   * @param  array $order       order
   * @param  ?int  $limit       limit
   * @param  ?int  $firstResult
   * @param  array $filter      selected field
   * @return array
   */
  public function findBy(array $query, array $order = [], ?int $limit, ?int $firstResult, array $filter): array
  {

    $q = $this -> repository
    -> createQueryBuilder(self::ALIAS);

    $q-> select(
      $this -> preparFilterToSelect($filter)
    );

    if(null !== $firstResult) {
      $q -> setFirstResult($firstResult);
    }

    if(null !== $limit) {
      $q -> setMaxResults($limit);
    }

    $q -> setParameters($query);

    foreach (array_keys( $query ) as $field) {
      #create query
      $q -> where(
        sprintf(
          "key = :param",
            self::alias . '.' . $field,
            $field
        )
      );
    }

    return $q -> getQuery() -> getResult();
  }

  /**
   * select other method
   * @param  [type] $method    [description]
   * @param  [type] $arguments [description]
   * @return [type]            [description]
   */
  public function __call($method, $arguments)
  {
    return call_user_func_array([$this -> repository, $method], $arguments);
  }

}
