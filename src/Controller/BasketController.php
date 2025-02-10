<?php

namespace App\Controller;

use App\Service\BasketService;
use App\Service\BreadcrumbService;
use App\Repository\FormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/basket', name: 'basket_')]
class BasketController extends AbstractController

{
    #[Route('/view', name: 'view')]
    public function showBasket(
        BasketService $basketService,
        EntityManagerInterface $manager,
        BreadcrumbService $breadcrumbService,
        ): Response
    {
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Panier', $this->generateUrl('basket_view'));
        //  $session->clear();

        //récupère le panier en session.
        $sessionBasket = $basketService->getSessionBasket();
        // récupère le panier en base
        $bddBasket = $basketService->loadBasket($this->getUser());

        // récupère le panier en base pour un customer identifié
        if($this->getUser()){
            //si le panier en session est vide et que le le panier en bdd n'est pas vide on ajoute les formats du panier en base vers la session
            if ($sessionBasket->isEmpty() && $bddBasket) {
                $idBasket = $bddBasket->getId();
                $bddBasketFormats = $basketService->loadBasketFormats($idBasket);

                // on injecte la nouvelle liste de formats dans le panier en session
                foreach($bddBasketFormats as $bddBasketFormat){
                $sessionBasket->add($bddBasketFormat);        
                } 
                $basketService->saveBasket($sessionBasket);
            }
        }

        // Initialiser les totaux à 0 pour éviter les erreurs
        $totalHT = 0;
        $totalTTC = 0;
        if ($sessionBasket->isEmpty()) {
            $sessionBasket = null;
        } else {
            $totalHT = $sessionBasket->reduce(fn($sum, $format)=> $sum + $format->getPriceHT(), 0);
            $totalTTC = $sessionBasket->reduce(fn($sum, $format)=> $sum + $format->getPriceTTC(), 0);
            if($bddBasket){
                $bddBasket->setTotalHT($totalHT);
                $bddBasket->setTotalTTC($totalTTC);
                $manager->persist($bddBasket);
                $manager->flush();
            }
        }

            // dd($sessionBasket, $session->getId());
        return $this->render('basket/index.html.twig', [
            'controller_name' => 'BasketController',
            'basket' => $sessionBasket,
            'orderBasket' => $bddBasket,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
            'breadcrumbs' => $breadcrumbService->get(),
        ]);
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(BasketService $basketService, Request $request, FormatRepository $formatRepository): Response
    {
        // on récupère les formats à partir des données choisies par l'utilisateur
        $choiceFormats = $request->get('format', []);
        $formats = $formatRepository->findByFormatChoices($choiceFormats);
        if (!$formats) {
            throw $this->createNotFoundException('Produit introuvable.');
        }
        $basketService->addToBasket($formats);

        return $this->redirectToRoute('basket_view');
    }


    #[Route('/remove-from-basket/{formatId}', name:'remove', methods:['POST'])]
    public function removeFromBasket(int $formatId, BasketService $basketService, FormatRepository $formatRepository)
    {
        $formatToRemove = $formatRepository->find($formatId);
        if (!$formatToRemove) {
            throw $this->createNotFoundException('Produit introuvable.');
        }
        $basketService->removeToBasket($formatToRemove, $this->getUser());

        // Rediriger vers la page panier (ou un autre endroit)
        return $this->redirectToRoute('basket_view');
    }

}