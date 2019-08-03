<?php

namespace App\Controller\Api\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/auth")
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="auth_index")
     */
    public function index()
    {
        return $this->json([
            'user' => $this -> getUser() -> getLogin(),
            'path' => 'src/Controller/IndexController.php',
        ]);
    }
}
