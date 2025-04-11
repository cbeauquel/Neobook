<?php

namespace App\Controller;

use App\Dto\BookWithAverageStars;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Service\BreadcrumbService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BookRepository $bookRepository, CategoryRepository $categoryRepository, BreadcrumbService $breadcrumbService): Response
    {
        // On récupère les livres avec la note moyenne
        $bookDtos = $bookRepository->findNew(12);

        $newBooks = [];
        $averageStarsMap = [];

        foreach ($bookDtos as $entry) {
            $newBooks[] = $entry->book;
            $averageStarsMap[$entry->book->getId()] = $entry->averageStars;
        }
        $upcomingBooks = $bookRepository->findByDate(6);
        $categories = $categoryRepository->findall();
        return $this->render('index.html.twig', [
            'controller_name' => 'MainController',
            'upcoming_books' => $upcomingBooks,
            'new_books' => $newBooks,
            'average_stars' => $averageStarsMap,
            'categories' => $categories,
        ]);
    }
}
