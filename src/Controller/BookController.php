<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\ToBeRead;
use App\Form\ToBeReadType;
use App\Repository\BookRepository;
use App\Repository\BoSkCoRepository;
use App\Service\BreadcrumbService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    #[Route('/book/{id}', name: 'book', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function showBook(
        Book $book,
        BookRepository $bookRepository,
        BoSkCoRepository $boSkCoRepository,
        Request $request,
        BreadcrumbService $breadcrumbService,
        EntityManagerInterface $entityManager,
        int $id,
    ): Response {
        $slug = $book->getTitle();
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Livre', $this->generateUrl('book', ['id' => $id]));
        $breadcrumbService->add(ucwords(str_replace('-', ' ', $slug)));


        $id = $request->get('id');
        $idContributors = $boSkCoRepository->findContributorByBookId($id);
        $booksByAuthors = $bookRepository->findByAuthorId($idContributors);

        /** @var \App\Entity\User|null $user */
        $user = $this->getUser(); // Récupération de l'utilisateur connecté
        $form = null;
        if ($user) {
            $toBeRead = new ToBeRead();
            $toBeRead->setStatus('à lire');
            $toBeRead->setCustomer($user);
            $toBeRead->setBook($book);

            $form = $this->createForm(ToBeReadType::class, $toBeRead);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($toBeRead);
                $entityManager->flush();

                // $this->addFlash('success', 'Le livre a été ajouté à votre liste de lecture.');
                return $this->redirectToRoute('customer_account');
            }
        }

        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
            'book' => $book,
            'books_by_authors' => $booksByAuthors,
            'breadcrumbs' => $breadcrumbService->get(),
            'slug' => $slug,
            'form' => $form,
        ]);
    }
}
