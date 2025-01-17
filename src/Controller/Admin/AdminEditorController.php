<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminEditorController extends AbstractController
{
    #[Route('/admin/editor', name: 'admin_editor')]
    public function listAllEditors(EditorRepository $editorRepository): Response
    {
        $allEditors = $editorRepository->findAll();
        
        return $this->render('admin/adminEditor.html.twig', [
            'controller_name' => 'AdminEditorController',
            'all_editors' => $allEditors,
        ]);
    }

    #[Route('/admin/addeditor', name: 'admin_editor_add')]
    public function createEditor(?Editor $editor, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $manager->persist($editor);
            $manager->flush();
            
            return $this->redirectToRoute('admin_editor');
        }

        return $this->render('admin/addEditorForm.html.twig', [
            'controller_name' => 'AdminEditorController',
            'form' => $form,
        ]);
    }
}
