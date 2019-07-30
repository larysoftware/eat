<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/auth")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("/logout", name="customer_logout")
     */
    public function logout()
    {
      throw new \Exception;
    }
}
