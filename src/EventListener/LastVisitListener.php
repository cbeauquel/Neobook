<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

final readonly class LastVisitListener
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[AsEventListener(event: 'security.interactive_login')]
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        // Récupère l'utilisateur
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof \App\Entity\User) {
            // Met à jour la date de la dernière visite
            $user->setLastVisitDate(new \DateTime());

            // Enregistre les modifications en base
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }
}
