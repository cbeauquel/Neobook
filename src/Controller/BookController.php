<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\ContributorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BookController extends AbstractController
{
    #[Route('/book/{id}', name: 'book', requirements: ['id' => '\d+'])]
    public function showBook(Book $book, ContributorRepository $contributorRepository, BookRepository $bookRepository, Request $request): Response
    {        
        $id = $request->get('id');
        $contributorId = $bookRepository->FindByBookId($id);
        $booksByAuthors = $bookRepository->findByAuthors($contributorId);
        // dd($contributorId);
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'book' => $book,
            'books_by_authors' => $booksByAuthors,
        ]);
    }


}
