<?php

namespace App\Controller;

use App\Entity\Category;
use App\Service\BreadcrumbService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'category', requirements: ['id' => '\d+'])]
    public function categoryBooks(Category $category, BreadcrumbService $breadcrumbService, int $id): Response
    {
        $slug = $category->getName();
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Catégorie', $this->generateUrl('category', ['id' => $id]));
        $breadcrumbService->add(ucwords(str_replace('-', ' ', $slug)));

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
            'breadcrumbs' => $breadcrumbService->get(),
            'slug' => $slug,
        ]);
    }
}
