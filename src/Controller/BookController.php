<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\BoSkCoRepository;
use App\Service\BreadcrumbService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BookController extends AbstractController
{
    #[Route('/book/{id}', name: 'book', requirements: ['id' => '\d+'])]
    public function showBook(
        Book $book, 
        BookRepository $bookRepository, 
        BoSkCoRepository $boSkCoRepository, 
        Request $request, 
        BreadcrumbService $breadcrumbService,
        int $id,
        ): Response
    {        
        $slug = $book->getTitle();
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Livre', $this->generateUrl('book', ['id' => $id]));
        $breadcrumbService->add(ucwords(str_replace('-', ' ', $slug)));
        $id = $request->get('id');
        $idContributors = $boSkCoRepository->FindContributorByBookId($id);
        $booksByAuthors = $bookRepository->FindByAuthorId($idContributors);
        // dd($booksByAuthors);
        // $session->clear();
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'book' => $book,
            'books_by_authors' => $booksByAuthors,
            'breadcrumbs' => $breadcrumbService->get(),
            'slug' => $slug,
        ]);
    }
}
