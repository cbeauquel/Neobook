<?php

namespace App\EventListener;

use App\Enum\BasketStatus;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class SessionExpiredListener
{
    private EntityManagerInterface $entityManager;
    private BasketRepository $basketRepository;
    private RequestStack $requestStack;

    public function __construct(
        EntityManagerInterface $entityManager,
        BasketRepository $basketRepository,
        RequestStack $requestStack
    ) {
        $this->entityManager = $entityManager;
        $this->basketRepository = $basketRepository;
        $this->requestStack = $requestStack;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $session = $this->requestStack->getSession();

        if (!$session->isStarted()) {
            return;
        }

        // Vérifier si un panier existait en session
        $basketId = $session->get('basket_id');

        if (!$basketId) {
            return;
        }

        // Vérifier si la session a expiré en regardant si elle a été recréée
        if (!$session->has('session_initialized')) {
            // Marquer la session comme initialisée
            $session->set('session_initialized', true);

            // Récupérer le panier en BDD
            $basket = $this->basketRepository->find($basketId);

            if ($basket && $basket->getStatus() !== BasketStatus::ABORTED) {
                $basket->setStatus(BasketStatus::ABORTED);
                $this->entityManager->persist($basket);
                $this->entityManager->flush();
            }
        }
    }
}