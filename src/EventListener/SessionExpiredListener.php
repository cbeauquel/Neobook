<?php

namespace App\EventListener;

use App\Enum\BasketStatus;
use App\Service\BasketService;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class SessionExpiredListener
{
    private EntityManagerInterface $entityManager;
    private Security $security;
    private BasketRepository $basketRepository;
    private BasketService $basketService;

    public function __construct(EntityManagerInterface $entityManager, Security $security, BasketRepository $basketRepository, BasketService $basketService)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->basketRepository = $basketRepository;
        $this->basketService = $basketService;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        
        // Vérifier si la session est expirée
        if (!$request->hasSession() || !$request->getSession()->isStarted()) {
            return;
        }

        $session = $request->getSession();
        $user = $this->security->getUser();

        // Vérifier si l'utilisateur n'est plus authentifié (session expirée)
        if (!$session->has('main') && $user) {
            // Récupérer ou créer un panier pour l'utilisateur
            $basket = $this->basketService->getOrCreateBddBasket($user);
            // dd($basket);
            // Vérifier si le panier est déjà en état "ABORTED"
            if ($basket->getStatus() !== BasketStatus::ABORTED) {
                $basket->setStatus(BasketStatus::ABORTED);
                $this->entityManager->persist($basket);
                $this->entityManager->flush();
            }
        }
    }
}