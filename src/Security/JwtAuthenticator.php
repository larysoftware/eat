<?php
namespace App\Security;

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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use App\Services\Response\ResponseCreatorInterface;
use App\Services\Customers\CustomersInterface;

class JwtAuthenticator extends AbstractGuardAuthenticator {

  private $em;

  private $responseFactory;

  private $tokenStorage;

  public function __construct(EntityManagerInterface $em, ResponseCreatorInterface $responseFactory, TokenStorageInterface $tokenStorage)
  {
      $this -> em = $em;
      $this -> responseFactory = $responseFactory;
      $this -> tokenStorage = $tokenStorage;
  }

  public function supports(Request $request)
  {
      return $request->headers->has('X-AUTH-TOKEN');
  }

  public function getCredentials(Request $request)
  {
    return [
      'token' => $request -> headers -> get('X-AUTH-TOKEN')
    ];
  }

  public function getUser($credentials, UserProviderInterface $userProvider)
  {

    # sprawdzam czy uzytkownik znajduje sie w tokenie
    # podmienic na inny rodzaj tokena bo to zwykla sesja trzymana w pliku
    # TokenStorageInterface
    if($this -> tokenStorage instanceof TokenStorageInterface
    && ($token = $this -> tokenStorage -> getToken()) !== null) {
      return $token -> getUser();
    }

    return $this -> em
    -> getRepository(Customers::class)
    -> findOneBy([
      'password' => $credentials['token']
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

    return $credentials['token'] === $user -> getPassword();
  }

  public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
  {

    return null;
  }

  public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
  {
    $data = [
      'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
    ];

    return $this -> responseFactory -> createResponse($data,
     Response::HTTP_FORBIDDEN);
  }

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
