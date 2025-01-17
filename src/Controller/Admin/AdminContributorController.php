<?php

namespace App\Controller\Admin;

use App\Entity\Contributor;
use App\Form\ContributorType;
use App\Repository\ContributorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/admin/addcontributor', name: 'admin_contributor_add')]
    public function createContributor(?Contributor $contributor, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ContributorType::class, $contributor);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){

            $manager->persist($contributor);
            $manager->flush();
            
            return $this->redirectToRoute('admin_contributor');
        }

        return $this->render('admin/addContributorForm.html.twig', [
            'controller_name' => 'AdminContributorController',
            'form' => $form,
        ]);
    }
}
