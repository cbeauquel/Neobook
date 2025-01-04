<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use App\Entity\Category;


class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'category', requirements: ['id' => '\d+'])]
    public function categoryBooks(Category $category): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
        ]);
    }
}
