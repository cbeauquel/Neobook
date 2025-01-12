<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BookRepository;
use App\Entity\Contributor;
use App\Repository\ContributorRepository;

class ContributorController extends AbstractController
{
    #[Route('/contributor/{id}', name: 'contributor', requirements: ['id' => '\d+'])]
    public function showContributor(Contributor $contributor, ContributorRepository $contributorRepository, BookRepository $bookRepository, Request $request): Response
    {
        $id = [$request->get('id')];
        $uniqSkills = $contributorRepository->findSkillsByAuthorId($id);
        $booksByAuthors = $bookRepository->FindByAuthorId($id);
        return $this->render('contributor/index.html.twig', [
            'contributor' => $contributor,
            'skills' => $uniqSkills,
            'books_by_author' => $booksByAuthors,
        ]);
    }
}
