<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\BookType;
use App\Entity\Contributor;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminBookController extends AbstractController
{
    #[Route('/admin/book', name: 'admin_book')]
    public function listAllBooks(BookRepository $bookRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = 10;

        try {
            $allBooks = $bookRepository->findPaginatedBooks($page, $limit);
        } catch (NotValidCurrentPageException $e) {
            return $this->json(['error' => 'Page non valide'], 400);
        }
        

        return $this->render('admin/adminBook.html.twig', [
            'controller_name' => 'AdminBookController',
            'all_books' => $allBooks,
        ]);
    }

    #[Route('/admin/book/add', name: 'admin_book_add')]
    #[Route('/admin/book/edit/{id}', name: 'admin_book_edit', requirements: ['id' => '\d+'])]
    public function createBook(
        ?Book $book, 
        Request $request, 
        EntityManagerInterface $manager, 
        SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/assets/img/livres')] string $coversDirectory,): Response
    {
        $book ??= new Book();

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            foreach ($book->getBoSkCos() as $boSkCo) {
                if (!$boSkCo->getContributor()) {
                    $boSkCo->setContributor(new Contributor());
                }
            }
                /** @var UploadedFile $cover */
                $cover = $form->get('cover')->getData();

                if ($cover){
                $originalCoverName = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeCoverName = $slugger->slug($originalCoverName);
                $newCoverName = $safeCoverName.'-'.uniqid().'.'.$cover->guessExtension();

                // Move the file to the directory where $pictures are stored
                try {
                    $cover->move($coversDirectory, $newCoverName);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            } else {
                $newCoverName = $book->getCover();
            }
            
            // updates the 'CoverName' property to store the IMG file name
            // instead of its contents
            $book->setCover($newCoverName);          

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

    #[Route('admin/book/remove/{id}', name: 'admin_book_remove', methods: ['GET', 'POST'])]
    public function remove(?Book $book, EntityManagerInterface $manager ): Response
    {
        $manager->remove($book);
        $manager->flush();
            
            return $this->redirectToRoute('admin_book');
    }

}
