<?php

namespace App\Services\Customers;

interface CustomersStorageInterface {

  /**
   * zlicza ilosc w danych warunkach
   * @param  array $query [description]
   * @return int          [description]
   */
  public function countByQuery(array $query): int;

  /**
   * zwraca jednego klienta
   * @param  array              $query [description]
   * @return ?CustomersInterface        [description]
   */
  public function findOneByQuery(array $query): ?CustomersInterface;

  /**
   * usuwa
   * @param  int    $id [description]
   * @throws \Exception
   */
  public function delete(CustomersInterface $customer);

  /**
   * aktualizuje klienta
   * @param  CustomersInterface $customer
   * @throws \Exception
   */
  public function update(CustomersInterface $customer);

  /**
   * create
   * @param  CustomersInterface $customer [description]
   * @throws \Exception
   */
  public function create(CustomersInterface $customer);

}
