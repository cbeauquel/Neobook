<?php

namespace App\Controller\Admin;

use App\Entity\Contributor;
use App\Form\ContributorType;
use App\Repository\ContributorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminContributorController extends AbstractController
{
    #[Route('/admin/contributor', name: 'admin_contributor')]
    public function listAllContributors(ContributorRepository $contributorRepository): Response
    {
        $allContributors = $contributorRepository->findAll();
        
        return $this->render('admin/adminContributor.html.twig', [
            'controller_name' => 'AdminContributorController',
            'all_contributors' => $allContributors,
        ]);
    }

    #[Route('/admin/contributor/add', name: 'admin_contributor_add')]
    #[Route('/admin/contributor/edit/{id}', name: 'admin_contributor_edit', requirements: ['id' => '\d+'])]
    public function createContributor(
        ?Contributor $contributor,
        Request $request,
        EntityManagerInterface $manager,
        SluggerInterface $slugger,
        #[Autowire('%kernel.project_dir%/assets/img/contributeurs')]
        string $photosDirectory,
    ): Response {
        $contributor ??= new Contributor();
        $form = $this->createForm(ContributorType::class, $contributor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();

            if ($photo) {
                $originalPhotoName = pathinfo((string) $photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safePhotoName = $slugger->slug($originalPhotoName);
                $newPhotoName = $safePhotoName . '-' . uniqid() . '.' . $photo->guessExtension();

                // Move the file to the directory where $pictures are stored
                try {
                    $photo->move($photosDirectory, $newPhotoName);
                } catch (FileException) {// @codeCoverageIgnore
                    // ... handle exception if something happens during file upload
                }
            } else {
                $newPhotoName = $contributor->getPhoto();
            }

            // updates the 'PhotoName' property to store the IMG file name
            // instead of its contents
            $contributor->setPhoto($newPhotoName);

            $manager->persist($contributor);
            $manager->flush();
            
            return $this->redirectToRoute('admin_contributor');
        }

        return $this->render('admin/addContributorForm.html.twig', [
            'controller_name' => 'AdminContributorController',
            'form' => $form,
            'contributor' => $contributor,
        ]);
    }

    #[Route('admin/contributor/remove/{id}', name: 'admin_contributor_remove', methods: ['GET', 'POST'])]
    public function remove(?Contributor $contributor, EntityManagerInterface $manager): Response
    {
        $manager->remove($contributor);
        $manager->flush();
            
        return $this->redirectToRoute('admin_contributor');
    }
}
