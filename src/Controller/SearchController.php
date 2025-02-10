<?php

namespace App\Controller;

use Meilisearch\Client;
use App\Entity\Book;
use App\Service\BreadcrumbService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SearchController extends AbstractController
{
    #[Route('/search', name: 'search', methods:['GET'])]
    public function search(Client $meilisearchClient, Request $request, BreadcrumbService $breadcrumbService): Response
    {
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Recherche', $this->generateUrl('search'));

        // Récupérer la recherche
        $query = $request->get('keyword', ''); 
        $results = [];

        if (!empty($query)) {
            $index = $meilisearchClient->index('app_dev_books'); // Nom de l'index
            $results = $index->search($query)->getHits();
        }
        // dd($results);
        // Retourne la vue avec le formulaire et les résultats
        return $this->render('search/search.html.twig', [
            'books' => $results,
            'breadcrumbs' => $breadcrumbService->get(),
            'query' => $query,
        ]);
    }
}
