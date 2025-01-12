<?php

namespace App\Controller;

use App\Entity\Editor;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditorController extends AbstractController
{
    #[Route('/editor/{id}', name: 'editor', requirements: ['id' => '\d+'])]
    public function showEditor(Editor $editor, BookRepository $bookRepository, $id): Response
    {
        $booksByEditor = $bookRepository->findByEditorId($id);
        return $this->render('editor/index.html.twig', [
            'controller_name' => 'EditorController',
            'editor' => $editor,
            'books_by_editor' => $booksByEditor,
        ]);
    }
}
