<?php

namespace App\Services\Customers;

interface CustomersInterface {

  public function getId(): ?int;

  public function getLogin(): ?string;

  public function setLogin(string $login): CustomersInterface;

  public function getCompany(): ?string;

  public function setCompany(string $company): CustomersInterface;

  public function getPhone(): ?string;

  public function setPhone(?string $phone): CustomersInterface;

  public function getEmail(): ?string;

  public function setEmail(string $email): CustomersInterface;

  public function getFax(): ?string;

  public function setFax(?string $fax): CustomersInterface;

  public function getContactName(): ?string;

  public function setContactName(string $contactName): CustomersInterface;

  public function getContactSurname(): ?string;

  public function setContactSurname(string $contactSurname): CustomersInterface;

  public function getIban(): ?string;

  public function setIban(?string $iban): CustomersInterface;

  public function getNip(): ?string;

  public function setNip(string $nip): CustomersInterface;

  public function getLogo(): ?string;

  public function setLogo(?string $logo): CustomersInterface;

  public function getCdate(): ?\DateTimeInterface;

  public function setCdate(\DateTimeInterface $cdate): CustomersInterface;

  public function getLastLogin(): ?\DateTimeInterface;

  public function setLastLogin(?\DateTimeInterface $lastLogin): CustomersInterface;

  public function getStreet(): ?string;

  public function setStreet(?string $street): CustomersInterface;

  public function getPostCode(): ?string;

  public function setPostCode(?string $postCode): CustomersInterface;
}
