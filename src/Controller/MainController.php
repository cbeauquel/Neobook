<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\BoSkCoRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BookRepository $bookRepository, CategoryRepository $categoryRepository): Response
    {
        $upcomingBooks = $bookRepository->findByDate();
        $categories = $categoryRepository->findall();
        // dd($upcomingBooks);
        return $this->render('index.html.twig', [
            'controller_name' => 'MainController',
            'upcoming_books' => $upcomingBooks,
            'categories' => $categories,
        ]);
    }
}
