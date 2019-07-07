<?php

namespace App\Customers;
use App\Entity\Customers;

interface FactoryInterface {
  /**
   * create customer
   * @param  array  $data [description]
   * @return Customers
   */
  public function registerCustomer(array $data) : ?Customers;
}
