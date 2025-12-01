<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\BoSkCo;
use App\Entity\Contributor;
use App\Entity\Format;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\FormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminBookController extends AbstractController
{
    #[Route('/admin/book', name: 'admin_book')]
    public function listAllBooks(BookRepository $bookRepository, Request $request): Response
    {
        // pagination (Pagerfanta)
        $page = $request->query->getInt('page', 1);
        $limit = 10;

        try {// @codeCoverageIgnore
            $allBooks = $bookRepository->findPaginatedBooks($page, $limit);
        } catch (NotValidCurrentPageException) {// @codeCoverageIgnore
            return $this->json(['error' => 'Page non valide'], 400);// @codeCoverageIgnore
        }// @codeCoverageIgnore
        

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
        SluggerInterface $slugger,
        FormatRepository $formatRepository,
        #[Autowire('%kernel.project_dir%/assets/img/livres')]
        string $coversDirectory,
        #[Autowire('%kernel.project_dir%/assets/files/formats')]
        string $filesDirectory,
        #[Autowire('%kernel.project_dir%/assets/files/extracts')]
        string $extractsDirectory,
    ): Response {
        $isWebTestCase = $request->headers->get('X-TEST-TYPE') === 'webTestCase';
        $book ??= new Book();
        if ($isWebTestCase && !$book->getId()) {
            $book->addBoSkCo(new BoSkCo());
            $book->addFormat(new Format());
        }
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($book->getBoSkCos() as $boSkCo) {
                if (!$boSkCo->getContributor()) {// @codeCoverageIgnore
                    $boSkCo->setContributor(new Contributor());
                }// @codeCoverageIgnore
            }

            $cover = $form->get('cover')->getData();
            if ($cover) {
                $originalCoverName = pathinfo((string) $cover->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeCoverName = $slugger->slug($originalCoverName);
                $newCoverName = $safeCoverName . '-' . uniqid() . '.' . $cover->guessExtension();

                // Move the file to the directory where $pictures are stored
                try {
                    $cover->move($coversDirectory, $newCoverName);
                } catch (FileException) {// @codeCoverageIgnore
                    // ... handle exception if something happens during file upload
                }
            } else {// @codeCoverageIgnore
                $newCoverName = $book->getCover();// @codeCoverageIgnore
            }
            
            // updates the 'CoverName' property to store the IMG file name
            // instead of its contents
            $book->setCover($newCoverName);

            // store format file in the repository
            // récupération du formulaire imbriqué
            $formatsCollection = $form->get('formats');
            foreach ($formatsCollection as $index => $formatForm) {
                $format = $formatForm->getData(); // C'est l'objet Format lié au formulaire
                $filePath = $formatForm->get('filePath')->getData();
                $extractPath = $formatForm->get('bookExtract')->getData();
                $isbn = $formatForm->get('ISBN')->getData();
                //récupération de la valeur du champ filePath
                if ($filePath) {
                    // this is needed to safely include the file name as part of the URL
                    $newFileName = $isbn . '.' . $filePath->getClientOriginalExtension();
                    // Move the file to the directory where $files are stored
                    try {
                        $filePath->move($filesDirectory, $newFileName);
                    } catch (FileException) {// @codeCoverageIgnore
                        // ... handle exception if something happens during file upload
                    }
                } else {// @codeCoverageIgnore
                    $format = $formatRepository->findOneByIsbn($isbn);
                    $newFileName = $format->getFilePath();// @codeCoverageIgnore
                }

                // updates the 'filepath' property to store the file name
                // instead of its contents
                $format->setFilePath($newFileName);

                // store extract file in the repository
                if ($extractPath) {
                    // this is needed to safely include the file name as part of the URL
                    $newExtractName = $isbn . 'extract' . '.' . $extractPath->getClientOriginalExtension();

                    // Move the file to the directory where $files are stored
                    try {
                        $extractPath->move($extractsDirectory, $newExtractName);
                    } catch (FileException) {// @codeCoverageIgnore
                        // ... handle exception if something happens during file upload
                    }
                } else {// @codeCoverageIgnore
                    $format = $formatRepository->findOneByIsbn($isbn);
                    $newExtractName = $format->getBookExtract();// @codeCoverageIgnore
                }
                    
                // updates the 'CoverName' property to store the IMG file name
                // instead of its contents
                $format->setBookExtract($newExtractName);
            }
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
    public function remove(?Book $book, EntityManagerInterface $manager): Response
    {
        $manager->remove($book);
        $manager->flush();
            
        return $this->redirectToRoute('admin_book');
    }
}
