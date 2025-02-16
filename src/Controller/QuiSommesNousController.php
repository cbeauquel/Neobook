<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuiSommesNousController extends AbstractController
{
    #[Route('/qui-sommes-nous', name: 'qui_sommes_nous')]
    public function quiSommesNous(): Response
    {
        return $this->render('contenu/qui-sommes-nous.html.twig', [
            'controller_name' => 'QuiSommesNousController',
        ]);
    }

    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('contenu/mentions-legales.html.twig', [
            'controller_name' => 'QuiSommesNousController',
        ]);
    }

    
    #[Route('/conditions-utilisation', name: 'conditions_utilisation')]
    public function conditionsUtilisation(): Response
    {
        return $this->render('contenu/conditions-utilisations.html.twig', [
            'controller_name' => 'QuiSommesNousController',
        ]);
    }
}
