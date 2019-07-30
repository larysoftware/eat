<?php
namespace App\Entity;

trait UserInterfaceTrait
{
  public function getUsername(): string
  {
      return $this -> getLogin();
  }

  public function getSalt()
  {
      return null;
  }

  public function getRoles(): array
  {
      return [
        'ROLE_USER'
      ];
  }

  public function eraseCredentials()
  {
  }
}
