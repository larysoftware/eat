<?php
/**
 * klasa zarzadzajaca klientami
 * @author lukasz7221@gmail.com
 *
 */
namespace App\Services\Customers;

class CustomersService {

  protected $repository;

  public function __construct(CustomersStorageInterface $repository)
  {
    $this -> repository = $repository;
  }

  /**
   * create
   * @param  CustomersInterface $customer [description]
   * @throws \Exception
   */
  public function register(CustomersInterface $customer)
  {
    $customer -> setCdate(new \DateTime);
    $this -> repository -> create($customer);
  }
}
