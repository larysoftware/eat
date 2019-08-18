<?php
/**
 * generator jwt
 */
namespace App\Security\Jwt;
use \Firebase\JWT\JWT;
use Symfony\Component\Security\Core\User\UserInterface;

class JwtGenerator implements JwtInterface {

  protected $secretKey = '';

  public function __construct(string $secretKey) {
    $this -> secretKey = $secretKey;
  }

  protected function createToken(UserInterface $context): array {
    return  [
      'userName' => $context -> getUsername()
    ];
  }

  /**
   * create token by UserInterface
   *
   * @param UserInterface $context
   * @return string
   */
  public function encode(UserInterface $context): string {

    return JWT::encode(
      $this -> createToken($context),
       $this -> secretKey
     );
  }

  /**
   * decode 
   *
   * @param string $jwt
   * @return array
   */
  public function decode(string $jwt): array {

    return (array)JWT::decode(
      $jwt,
      $this -> secretKey,
      ['HS256']
    );
  }

  /**
   * sprawdzam poprawnosc tokenu
   * @param  string        $jwt     [description]
   * @param  UserInterface $context [description]
   * @return bool                   [description]
   */
  public function check(string $jwt, UserInterface $context): bool {
    $jwtData = $this -> decode($jwt);
    return $this -> createToken($context) === $jwtData;

  }

}
