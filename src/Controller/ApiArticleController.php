<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiArticleController extends AbstractController
{
    
    public function __construct(
        private readonly ArticleRepository $articleRepository
    ){}

    #[Route('/api/articles', name: 'api_article_all')]
    public function getAllArticles(): Response
    {
        return $this->json(
            $this->articleRepository->findAll(),
            200,
            [],
            ['groups'=>'article:read']
        );
    }
}
