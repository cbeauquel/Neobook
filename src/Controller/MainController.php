<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\BoSkCoRepository;
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
        $newBooks = $bookRepository->findNew(12);
        $upcomingBooks = $bookRepository->findByDate(6);
        // dd($upcomingBooks, $newBooks);
        $categories = $categoryRepository->findall();
        return $this->render('index.html.twig', [
            'controller_name' => 'MainController',
            'upcoming_books' => $upcomingBooks,
            'new_books' => $newBooks,
            'categories' => $categories,
        ]);
    }
}
