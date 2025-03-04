<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(): Response
    {
        return $this->render('articles/articles.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }
    #[Route('/articles/article', name: 'app_articles_article')]
    public function articleId(): Response
    {
        return $this->render('articles/oneArticle.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }
}
