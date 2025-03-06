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

    #[Route('/api/articles/{id}', name: 'api_article_id')]
    public function getArticleById(int $id): Response
    {
        $article = $this->articleRepository->find($id);

        if (!$article) {
            return $this->json(['message' => 'Article not found'], 404);
        }

        return $this->json(
            $article,
            200,
            [],
            ['groups' => 'article:read']
        );
    }
}
