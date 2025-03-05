<?php

namespace App\Controller;

use App\Repository\CategoryRepository as RepositoryCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;

final class CategoryController extends AbstractController
{

    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ){}

    #[Route('/category', name: 'app_category')]
    public function showAllCategories(): Response
    {
        $categories = $this->categoryRepository->findAll();

        dd($categories);
        return $this->render('category/categories.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
