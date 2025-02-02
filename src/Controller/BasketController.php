<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Basket;
use App\Service\BasketService;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\BasketRepository;
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
    private $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    #[Route('/add/{id}', name: 'add')]
    public function addToBasket(BasketService $basketService, Request $request, FormatRepository $formatRepository): Response
    {
        // on récupère les formats à partir des données choisies par l'utilisateur
        $choiceFormats = $request->get('format', []);
        $formats = $formatRepository->findByFormatChoices($choiceFormats);
        if (!$formats) {
            throw $this->createNotFoundException('Produit introuvable.');
        }
        $basketService->addToBasket($formats);

        $basketService->persistBasket($this->getUser());

        return $this->redirectToRoute('basket_view');
    }

    #[Route('/view', name: 'view')]
    public function showBasket(
        BasketService $basketService,
        SessionInterface $session,
        EntityManagerInterface $manager,
        ): Response
    {
       // $session->clear();
        //récupère le panier en session.
        $sessionBasket = $basketService->getOrCreateSessionBasket();

        // récupère le panier en base
        $bddBasket = $basketService->loadBasket($this->getUser());

        if ($sessionBasket->isEmpty() && $bddBasket) {
            $idBasket = $bddBasket->getId();
            $bddBasketFormats = $basketService->loadBasketFormats($idBasket);

            // on injecte la nouvelle liste de formats dans le panier en base
            foreach($bddBasketFormats as $bddBasketFormat){
            $sessionBasket->add($bddBasketFormat);        
            } 
        }
        // dd($bddBasketFormats, $sessionBasket);
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

        //  dd($sessionBasket);
        return $this->render('basket/index.html.twig', [
            'controller_name' => 'BasketController',
            'basket' => $sessionBasket,
            'orderBasket' => $bddBasket,
            'totalHT' => $totalHT,
            'totalTTC' => $totalTTC,
        ]);
    }

    #[Route('/remove-from-basket/{formatId}', name:'remove', methods:['POST'])]
    public function removeFromBasket(int $formatId, BasketService $basketService, FormatRepository $formatRepository)
    {
        $formatToRemove = $formatRepository->find($formatId);
        if (!$formatToRemove) {
            throw $this->createNotFoundException('Produit introuvable.');
        }
        $basketService->removeToBasket($formatToRemove);

        $basketService->persistBasket($this->getUser());

        // Rediriger vers la page panier (ou un autre endroit)
        return $this->redirectToRoute('basket_view');
    }
}