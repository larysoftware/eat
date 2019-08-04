<?php
namespace App\Security\Jwt;
use Symfony\Component\Security\Core\User\UserInterface;

interface JwtInterface {

  public function encode(UserInterface $context): string;
  public function decode(string $jwt): array;
  public function check(string $jwt, UserInterface $context): bool;
}
