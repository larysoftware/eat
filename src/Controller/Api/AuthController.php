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
    public function index(AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils -> getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authUtils -> getLastUsername();

        return $this-> json([
          'error' => $error,
          'username' => $lastUsername
        ]);
    }
}
