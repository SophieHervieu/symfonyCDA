<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping\Id;

final class ArticlesController extends AbstractController
{

    public function __construct(
        private readonly ArticleRepository $articleRepository
    ){}

    #[Route('/articles', name: 'app_articles_all')]
    public function showAllArticles(): Response
    {
        return $this->render('articles/articles.html.twig', [
            'articles' => $this->articleRepository->findAll(),
        ]);
    }
    #[Route('/articles/{id}', name: 'app_article_show')]
    public function showArticle(int $id): Response
    {
        return $this->render('articles/oneArticle.html.twig', [
            'article' => $this->articleRepository->find($id),
        ]);
    }
}
