<?php

namespace App\EventListener;

use App\Enum\BasketStatus;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\session;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class SessionExpiredListener
{
    // Durée d'expiration de la session

    public function __construct(private EntityManagerInterface $manager, private BasketRepository $basketRepository, private RequestStack $requestStack, private int $sessionLifetime = 120)
    {
    }

    #[AsEventListener(event: 'kernel.request')]
    public function onKernelRequest(RequestEvent $event, string $session): void
    {
        $session = $this->requestStack->getSession();
        if (!$session->isStarted()) {
            return;
        }
        $currentTime = time();
        $lastActivity = $session->get('last_activity');
        // Mettre à jour le timestamp de dernière activité
        if (!$lastActivity || ($currentTime - $lastActivity > $this->sessionLifetime)) {
            $this->handleExpiredSession($session);
        }
        $session->set('last_activity', $currentTime);
    }
    
    /**
     *@param SessionInterface $session
     */
    private function handleExpiredSession($session): void
    {
        $basketId = $session->getId();

        if ($basketId) {
            $basket = $this->basketRepository->findBasketByUserToken($basketId);

            if ($basket && $basket->getStatus() !== BasketStatus::ABORTED) {
                $basket->setStatus(BasketStatus::ABORTED);
                $this->manager->persist($basket);
                $this->manager->flush();
            }
        }

        // Réinitialiser la session
        $session->remove('last_activity');
    }
}
