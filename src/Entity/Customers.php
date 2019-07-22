<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Services\Customers\CustomersInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomersRepository")
 */
class Customers implements CustomersInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contactName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contactSurname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $iban;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $nip;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $cdate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $postCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): CustomersInterface
    {
        $this->login = $login;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): CustomersInterface
    {
        $this->company = $company;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): CustomersInterface
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): CustomersInterface
    {
        $this->email = $email;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): CustomersInterface
    {
        $this->fax = $fax;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(string $contactName): CustomersInterface
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getContactSurname(): ?string
    {
        return $this->contactSurname;
    }

    public function setContactSurname(string $contactSurname): CustomersInterface
    {
        $this->contactSurname = $contactSurname;

        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): CustomersInterface
    {
        $this->iban = $iban;

        return $this;
    }

    public function getNip(): ?string
    {
        return $this->nip;
    }

    public function setNip(string $nip): CustomersInterface
    {
        $this->nip = $nip;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): CustomersInterface
    {
        $this->logo = $logo;

        return $this;
    }

    public function getCdate(): ?\DateTimeInterface
    {
        return $this->cdate;
    }

    public function setCdate(\DateTimeInterface $cdate): CustomersInterface
    {
        $this->cdate = $cdate;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): CustomersInterface
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): CustomersInterface
    {
        $this->street = $street;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): CustomersInterface
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
