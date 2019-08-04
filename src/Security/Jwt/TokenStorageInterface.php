<?php
namespace App\Security\Jwt;

interface TokenStorageInterface {

  /**
   * sprawdzam czy token istnieje
   * @param  string $token [description]
   * @return bool          [description]
   */
  public function exists(string $token): bool;

  /**
   * ustawia token
   * @param  string $token
   * @return TokenStorageInterface
   */
  public function get(string $token): ?string;

  /**
   * token
   * @param  string                $string [description]
   * @param  string                $value  [description]
   * @return TokenStorageInterface
   */
  public function set(string $string, string $value): TokenStorageInterface;

}
