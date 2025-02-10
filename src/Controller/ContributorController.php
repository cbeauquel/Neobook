<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookRepository;
use App\Entity\Contributor;
use App\Repository\ContributorRepository;
use App\Service\BreadcrumbService;

class ContributorController extends AbstractController
{
    #[Route('/contributor/{id}', name: 'contributor', requirements: ['id' => '\d+'])]
    public function showContributor(
        Contributor $contributor, 
        ContributorRepository $contributorRepository, 
        BookRepository $bookRepository, 
        Request $request,
        BreadcrumbService $breadcrumbService,
        int $id,
        ): Response
    {
        $slug = $contributor->getSlug();
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Contributeur', $this->generateUrl('contributor', ['id' => $id]));
        $breadcrumbService->add(ucwords(str_replace('-', ' ', $slug)));

        $id = [$request->get('id')];
        $uniqSkills = $contributorRepository->findSkillsByAuthorId($id);
        $booksByAuthors = $bookRepository->FindByAuthorId($id);
        return $this->render('contributor/index.html.twig', [
            'contributor' => $contributor,
            'skills' => $uniqSkills,
            'books_by_author' => $booksByAuthors,
            'breadcrumbs' => $breadcrumbService->get(),
            'slug' => $slug,
        ]);
    }
}
