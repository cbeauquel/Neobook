<?php

namespace App\EventListener;

use App\Service\BasketService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

final readonly class LoginListener
{
    public function __construct(private BasketService $basketService)
    {
    }

    #[AsEventListener(event: 'security.interactive_login')]
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof \App\Entity\User) {
            // Synchronise le panier avec l'utilisateur connecté
            $this->basketService->persistBasket($user);
        }
    }
}
