<?php

/**
 * Klasa utrzymująca token w Redis
 * @author l.surdy@webd.pl
 */
namespace App\Security\Jwt;
use RedisClient\RedisClient;

class TokenStorage implements TokenStorageInterface {

  protected $redisClient;

  protected $config = [];

  public function __construct(RedisClient $redisClient) {

    $this -> redisClient = $redisClient;
  }

  /**
   * config
   * @param  array                 $config [description]
   * @return TokenStorageInterface         [description]
   */
  public function setConfig(array $config): TokenStorageInterface {
    $this -> config = $config;
    return $this;
  }

  /**
   * ustawia token
   * @param  string $token
   * @return TokenStorageInterface
   */
  public function get(string $token): ?string {
    return $this -> redisClient -> get($token);
  }

  /**
   * token
   * @param  string                $string
   * @param  string                $value
   * @return TokenStorageInterface
   */
  public function set(string $string, string $value): TokenStorageInterface
  {
    $this -> redisClient -> set($string, $value, $this -> config);

    return $this;
  }


  /**
   * sprawdza czy token istnieje
   * @param  string $token
   * @return bool
   */
  public function exists(string $token): bool
  {
      return $this -> redisClient -> exists($token);
  }

}
