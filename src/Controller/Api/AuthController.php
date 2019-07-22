<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/api/auth")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index()
    {

      $user = $this->getUser();

      return $this->json([
          'username' => $user->getUsername(),
          'roles' => $user->getRoles(),
      ]);
    }
}
