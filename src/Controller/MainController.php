<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\BoSkCoRepository;
use App\Repository\CategoryRepository;
use App\Service\BreadcrumbService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BookRepository $bookRepository, CategoryRepository $categoryRepository, BreadcrumbService $breadcrumbService): Response
    {       
        $newBooks = $bookRepository->findNew();
        $upcomingBooks = $bookRepository->findByDate();
        $categories = $categoryRepository->findall();
        // dd($upcomingBooks);
        return $this->render('index.html.twig', [
            'controller_name' => 'MainController',
            'upcoming_books' => $upcomingBooks,
            'new_books' => $newBooks,
            'categories' => $categories,
        ]);
    }
}
