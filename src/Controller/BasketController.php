<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\FormatRepository;
use App\Service\BasketService;
use App\Service\BreadcrumbService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/basket', name: 'basket_')]
class BasketController extends AbstractController
{
    #[Route('/view', name: 'view')]
    public function showBasket(
        BasketService $basketService,
        EntityManagerInterface $manager,
        BreadcrumbService $breadcrumbService,
        SessionInterface $session,
    ): Response {
        //Fil d'ariane
        $breadcrumbService->add('Accueil', $this->generateUrl('home'));
        $breadcrumbService->add('Panier', $this->generateUrl('basket_view'));

        //récupère le panier en session.
        $userToken = $session->getId();
        $sessionBasket = $basketService->getSessionBasket();

        // récupère le panier en base
        $customer = $this->getUser();
        $oldBasket = $basketService->loadAllBaskets($userToken);
        $bddBasket = $basketService->loadBasket($customer);

        // Si le panier en session est vide et que le panier en base n'est pas vide
        if ($sessionBasket->isEmpty() && $bddBasket) {
            // Si un utilisateur est connecté
            $idBasket = $bddBasket->getId();
            $bddBasketFormats = $basketService->loadBasketFormats($idBasket);
            if ($bddBasketFormats->isEmpty()) {
                $manager->remove($bddBasket);
                $manager->flush();
            } else {
                // on injecte la nouvelle liste de formats dans le panier en session
                foreach ($bddBasketFormats as $bddBasketFormat) {
                    $sessionBasket->add($bddBasketFormat);
                }
                $basketService->saveBasket($sessionBasket);
            }

            $manager->remove($bddBasket);
            $manager->flush();
        }
        // elseif (!$oldBasket) {
        //     $session->remove($sessionBasket);
        // }
        // Initialiser les totaux à 0 pour éviter les erreurs
        $totalHT = 0;
        $totalTTC = 0;
        if ($sessionBasket->isEmpty()) {
            $sessionBasket = null;
        } else {
            $totalHT = $sessionBasket->reduce(fn ($sum, $format) => $sum + $format->getPriceHT(), '0');
            $totalTTC = $sessionBasket->reduce(fn ($sum, $format) => $sum + $format->getPriceTTC(), '0');
            if ($bddBasket) {
                $bddBasket->setTotalHT($totalHT);
                $bddBasket->setTotalTTC($totalTTC);
                $manager->persist($bddBasket);
                $manager->flush();
            }
        }

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
    public function add(
        BasketService $basketService,
        Request $request,
        FormatRepository $formatRepository,
    ): Response {
        $customer = $this->getUser();
        if (!$customer instanceof User) {
            $customer = null;
        }
        // on récupère les formats à partir des données choisies par l'utilisateur
        $choiceFormats = $request->get('format', []);
        $formats = $formatRepository->findByFormatChoices($choiceFormats);
        // if (!$formats) {
        //     throw $this->createNotFoundException('Produit introuvable.');
        // }
        $basketService->addToBasket($formats, $customer);
        return $this->redirectToRoute('basket_view');
    }

    #[Route('/remove-from-basket/{formatId}', name: 'remove', methods: ['POST'])]
    public function removeFromBasket(int $formatId, BasketService $basketService, FormatRepository $formatRepository, ?User $user): response
    {
        $customer = $this->getUser();
        $formatToRemove = $formatRepository->find($formatId);

        $basketService->removeToBasket($formatToRemove, $customer);

        // Rediriger vers la page panier (ou un autre endroit)
        return $this->redirectToRoute('basket_view');
    }
}
