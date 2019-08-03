<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use RedisClient\RedisClient;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(RedisClient $redis)
    {

        $redis -> set('x', 'lala');

        $value = $redis -> get('x');

        return $this->json([
            'message' => $value
        ]);
    }
}
