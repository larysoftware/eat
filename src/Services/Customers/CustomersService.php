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
   * update customer
   * @param  CustomersInterface $customer [description]
   * @throws \Exception
   */
  public function update(CustomersInterface $customer)
  {
    $this -> repository -> update($customer);
  }

  /**
   * delete
   * @param  CustomersInterface $customer [description]
   * @throws \Exception
   */
  public function delete(CustomersInterface $customer)
  {
    $this -> repository -> delete($customer);
  }

  /**
   * create
   * @param  CustomersInterface $customer [description]
   * @throws \Exception
   */
  public function register(CustomersInterface $customer)
  {
    $customer -> setCdate(new \DateTime);
    $customer -> setPassword(md5( $customer -> getPassword() ));
    $this -> repository -> create($customer);
  }
}
