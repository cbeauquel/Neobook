<?php

namespace App\Controller;

use App\Dto\BookWithAverageStars;
use App\Entity\Contributor;
use App\Repository\BookRepository;
use App\Repository\ContributorRepository;
use App\Service\BreadcrumbService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    ): Response {
        $slug = $contributor->getSlug();
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Contributeur', $this->generateUrl('contributor', ['id' => $id]));
        $breadcrumbService->add(ucwords(str_replace('-', ' ', $slug)));

        $id = [$request->get('id')];
        
        $booksByAuthors = $bookRepository->findByAuthorId($id);
        $uniqSkills = $contributorRepository->findSkillsByAuthorId($id);
        return $this->render('contributor/index.html.twig', [
            'contributor' => $contributor,
            'skills' => $uniqSkills,
            'books_by_author' => $booksByAuthors,
            'breadcrumbs' => $breadcrumbService->get(),
            'slug' => $slug,
        ]);
    }
}
