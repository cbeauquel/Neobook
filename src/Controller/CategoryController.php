<?php

namespace App\Controller;

use App\Dto\BookWithAverageStars;
use App\Entity\Category;
use App\Repository\BookRepository;
use App\Service\BreadcrumbService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'category', requirements: ['id' => '\d+'])]
    public function categoryBooks(Category $category, BookRepository $bookRepository, BreadcrumbService $breadcrumbService, Request $request, int $id): Response
    {
        $slug = $category->getName();
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Catégorie', $this->generateUrl('category', ['id' => $id]));
        $breadcrumbService->add(ucwords(str_replace('-', ' ', $slug)));

        $id = [$request->get('id')];

        // On récupère les livres avec la note moyenne
        $bookDtos = $bookRepository->findByCategoryId($id);

        $booksByCategory = [];
        $averageStarsMap = [];

        foreach ($bookDtos as $entry) {
            $booksByCategory[] = $entry->book;
            $averageStarsMap[$entry->book->getId()] = $entry->averageStars;
        }

        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
            'books_by_category' => $booksByCategory,
            'average_stars' => $averageStarsMap,
            'breadcrumbs' => $breadcrumbService->get(),
            'slug' => $slug,
        ]);
    }
}
