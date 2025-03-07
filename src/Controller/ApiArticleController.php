<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\AccountRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ApiArticleController extends AbstractController
{

    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly AccountRepository $accountRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly EntityManagerInterface $em,
        private readonly SerializerInterface $serializer
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

    #[Route('/api/article', name: 'app_article_add', methods: ['POST'])]
    public function addArticle(Request $request): Response
    {
        //Récupération le body de la requête
        $request = $request->getContent();
        //Convertir en objet Article
        $article = $this->serializer->deserialize($request, Article::class, 'json');
        if($article->getTitle() && $article->getContent() && $article->getAuthor()) {

            //récupération du compte
            $article->setAuthor($this->accountRepository->findOneBy(["email" => $article->getAuthor()->getEmail()]));

            //Récupération des catégories
            foreach ($article->getCategories() as $key => $value) {
                $cat = $value->getName();
                $article->removeCategory($value);
                $cat = $this->categoryRepository->findOneBy(["name" => $cat]);
                $article->addCategory($cat);
            }

        //Tester si l'article n'existe pas
            if (!$this->articleRepository->findOneBy(["title" => $article->getTitle(), "content" => $article->getContent()])) {
                $this->em->persist($article);
                $this->em->flush();
                $code = 201;
            }
            //S'il existe déjà
            else {
                $article = "L'article existe déjà";
                $code = 400;
            }
        }
        else {
            $code = 400;
            $article = "Les champs ne sont pas tous remplis";
        }
        return $this->json($article, $code, [
            "Access-Control-Allow-Origin" => "*",
            "Content-Type" => "application/json"
        ], ['groups' => 'articles:read']);
    }
}
