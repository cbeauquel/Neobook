<?php

namespace App\Controller\Admin;

use App\Entity\Editor;
use App\Form\EditorType;
use App\Repository\EditorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    #[Route('/admin/editor/add', name: 'admin_editor_add')]
    #[Route('/admin/editor/edit/{id}', name: 'admin_editor_edit', requirements: ['id' => '\d+'])]
    public function createEditor(
        ?Editor $editor,
        Request $request,
        EntityManagerInterface $manager,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/assets/img/editeurs')]
        string $logosDirectory,
    ): Response {
        $editor ??= new Editor();

        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logo = $form->get('logo')->getData();
            // dd($logo);
            if ($logo) {
                $originalLogoName = pathinfo((string) $logo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeLogoName = $slugger->slug($originalLogoName);
                $newLogoName = $safeLogoName . '-' . uniqid() . '.' . $logo->guessExtension();

                // Move the file to the directory where $pictures are stored
                try {
                    $logo->move($logosDirectory, $newLogoName);
                } catch (FileException) {// @codeCoverageIgnore
                    // ... handle exception if something happens during file upload
                }
            } else {
                $newLogoName = $editor->getLogo();
            }

            // updates the 'LogoName' property to store the IMG file name
            // instead of its contents
            $editor->setLogo($newLogoName);

            $manager->persist($editor);
            $manager->flush();
            
            return $this->redirectToRoute('admin_editor');
        }

        return $this->render('admin/addEditorForm.html.twig', [
            'controller_name' => 'AdminEditorController',
            'form' => $form,
            'editor' => $editor,
        ]);
    }

    #[Route('admin/editor/remove/{id}', name: 'admin_editor_remove', methods: ['GET', 'POST'])]
    public function remove(?Editor $editor, EntityManagerInterface $manager): Response
    {
        $manager->remove($editor);
        $manager->flush();
            
        return $this->redirectToRoute('admin_book');
    }
}
