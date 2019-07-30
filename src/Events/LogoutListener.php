<?php
/**
 * event wykonywany w trakcie wlogowania klienta
 * @author lukasz7221@gmail.com
 */
namespace App\Events;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

use App\Services\Response\ResponseCreatorInterface;

class LogoutListener implements LogoutHandlerInterface
{

    protected $responseFactory;

    public function __construct(ResponseCreatorInterface $responseFactory)
    {
      $this -> responseFactory = $responseFactory;
    }

    /**
     * @{inheritDoc}
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
      return $this -> responseFactory -> createResponse([
        'message' => 'the user has been correctly logged out'
      ], Response::HTTP_OK);
    }
}
