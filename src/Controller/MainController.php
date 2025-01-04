<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BookRepository $bookRepository, CategoryRepository $categoryRepository): Response
    {
        $upcomingBooks = $bookRepository->findByDate();
        $categories = $categoryRepository->findall();

        return $this->render('index.html.twig', [
            'controller_name' => 'MainController',
            'upcoming_books' => $upcomingBooks,
            'categories' => $categories,
        ]);
    }
}
