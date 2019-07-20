<?php

namespace App\Services\Customers;

interface CustomersStorageInterface {

  /**
   * zwraca jednego klienta
   * @param  array              $query [description]
   * @return CustomersInterface        [description]
   */
  public function findOneByQuery(array $query): CustomersInterface;

  /**
   * usuwa
   * @param  int    $id [description]
   * @throws \Exception
   */
  public function delete(int $id);

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
