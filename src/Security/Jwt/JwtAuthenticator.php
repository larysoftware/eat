<?php
namespace App\Security\Jwt;

use App\Entity\Customers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

use App\Services\Response\ResponseCreatorInterface;
use App\Services\Customers\CustomersInterface;
use RedisClient\RedisClient;

class JwtAuthenticator extends AbstractGuardAuthenticator {

  private const PASSWORD = '_password';
  private const USERNAME = '_login';

  private $em;

  private $responseFactory;
  /**
   * rdis client for storage token
   * @var RedisClient
   */
  private $redsClient;


  public function __construct(EntityManagerInterface $em, ResponseCreatorInterface $responseFactory, RedisClient $redis)
  {
      $this -> em = $em;
      $this -> responseFactory = $responseFactory;
      $this -> redisClient = $redis;
  }

  /**
   * sprawdzam czy wykonac autentykacje
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function supports(Request $request)
  {
      $pasword = $request-> request -> has(self::PASSWORD);
      $login = $request-> request -> has(self::USERNAME);

      return $pasword && $login;
  }

  /**
   * pobieram dane do uwierzyteleniania
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function getCredentials(Request $request)
  {
    return [
      'password' => $request -> request -> get(self::PASSWORD),
      'login' => $request -> request -> get(self::USERNAME)
    ];
  }

  /**
   * zwracam uzytkownika
   * @param  [type]                $credentials  [description]
   * @param  UserProviderInterface $userProvider [description]
   * @return [type]                              [description]
   */
  public function getUser($credentials, UserProviderInterface $userProvider)
  {

    return $this -> em
    -> getRepository(Customers::class)
    -> findOneBy([
      'password' => $credentials['password'],
      'login' => $credentials['login']
    ]);
  }


  public function checkCredentials($credentials, UserInterface $user)
  {

    #sprawdzam czy uzytkownik implementuje odpowiedni interface
    if(false == ($user instanceof CustomersInterface)) {

      throw new \Exception(sprintf(
        'user is not instanceof %s',
        CustomersInterface::class
      ));

    }

    return $credentials['password'] === $user -> getPassword();
  }


  /**
   * sukcej autentykacji
   * @param  Request        $request     [description]
   * @param  TokenInterface $token       [description]
   * @param  [type]         $providerKey [description]
   * @return [type]                      [description]
   */
  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
  {

    # tworze testowy token
    $user = $token -> getUser();
    $tokenKey = md5($user -> getLogin() . $user -> getPassword());

    # jesli token istnieje to juz go nie tworz
    if(!$this -> redisClient -> exists($tokenKey)) {
      $this -> redisClient -> set($tokenKey, $user -> getUsername());
    }

    $data = [
      'token' => $tokenKey
    ];

    return $this -> responseFactory -> createResponse($data, Response::HTTP_OK);
  }

  /**
   * metoda wykonywana gdy autentykacja napotka blad
   * @param  Request                 $request   [description]
   * @param  AuthenticationException $exception [description]
   * @return [type]                             [description]
   */
  public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
  {
    $data = [
      'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
    ];

    return $this -> responseFactory -> createResponse($data,
     Response::HTTP_FORBIDDEN);
  }

  /**
   * metoda wykonywana gdy wymagana jest autoryzacja
   * @param  Request $request       [description]
   * @param  [type]  $authException [description]
   * @return [type]                 [description]
   */
  public function start(Request $request, AuthenticationException $authException = null)
  {

    $data = [
        'message' => 'Authentication Required'
    ];

    return $this -> responseFactory -> createResponse($data, Response::HTTP_UNAUTHORIZED);
  }

  public function supportsRememberMe()
  {
    return false;
  }

}
