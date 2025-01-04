<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Book;

class BookController extends AbstractController
{
    #[Route('/book/{id}', name: 'book', requirements: ['id' => '\d+'])]
    public function showBook(Book $book): Response
    {
        
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'book' => $book,
        ]);
    }
}
