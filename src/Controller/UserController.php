<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user/register', name: 'app_user')]
    public function register(): Response
    {
        return $this->render('user/register.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/user/connection', name: 'app_user_connect')]
    public function connection(): Response
    {
        return $this->render('user/connection.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
