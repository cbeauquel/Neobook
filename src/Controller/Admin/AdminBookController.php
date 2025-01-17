<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManager;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookController extends AbstractController
{
    #[Route('/admin/book', name: 'admin_book')]
    public function listAllBooks(BookRepository $bookRepository): Response
    {
        $allBooks = $bookRepository->findAll();
        

        return $this->render('admin/adminBook.html.twig', [
            'controller_name' => 'AdminBookController',
            'all_books' => $allBooks,
        ]);
    }

    #[Route('/admin/addbook', name: 'admin_book_add')]
    #[Route('/admin/editbook/{id}', name: 'admin_book_edit', requirements: ['id' => '\d+'])]
    public function createBook(?Book $book, Request $request, EntityManagerInterface $manager): Response
    {
        $book ??= new Book;

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $manager->persist($book);
            $manager->flush();
            
            return $this->redirectToRoute('admin_book');
        }


        return $this->render('admin/addBookForm.html.twig', [
            'controller_name' => 'AdminBookController',
            'form' => $form,
            'book' => $book,
        ]);
    }
}
