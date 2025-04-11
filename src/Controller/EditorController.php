<?php

namespace App\Controller;

use App\Dto\BookWithAverageStars;
use App\Entity\Editor;
use App\Repository\BookRepository;
use App\Service\BreadcrumbService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditorController extends AbstractController
{
    #[Route('/editor/{id}', name: 'editor', requirements: ['id' => '\d+'])]
    public function showEditor(Editor $editor, BookRepository $bookRepository, BreadcrumbService $breadcrumbService, Request $request, int $id): Response
    {
        $slug = $editor->getName();
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Éditeur', $this->generateUrl('editor', ['id' => $id]));
        $breadcrumbService->add(ucwords(str_replace('-', ' ', $slug)));

        $id = [$request->get('id')];

        // On récupère les livres avec la note moyenne
        $bookDtos = $bookRepository->findByEditorId($id);

        $booksByEditor = [];
        $averageStarsMap = [];

        foreach ($bookDtos as $entry) {
            $booksByEditor[] = $entry->book;
            $averageStarsMap[$entry->book->getId()] = $entry->averageStars;
        }
        
        return $this->render('editor/index.html.twig', [
            'controller_name' => 'EditorController',
            'editor' => $editor,
            'books_by_editor' => $booksByEditor,
            'average_stars' => $averageStarsMap,
            'breadcrumbs' => $breadcrumbService->get(),
            'slug' => $slug,

        ]);
    }
}
