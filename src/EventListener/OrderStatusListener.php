<?php

namespace App\EventListener;

use App\Entity\Order;
use App\Service\DownloadLinkManagerService;
use App\Service\EmailService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface; // Votre service d'email existant

#[AsEntityListener(event: Events::postUpdate, method: 'onOrderStatusUpdate', entity: Order::class)]
class OrderStatusListener
{
    public function __construct(
        private readonly DownloadLinkManagerService $downloadLinkManager,
        private readonly EmailService $emailService,
        private readonly LoggerInterface $logger
    ) {
    }

    public function onOrderStatusUpdate(Order $order, PostUpdateEventArgs $event): void
    {
        // Vérifier si le statut de la commande est "Paiement accepté"
        if ($order->getStatus()->getStatus() === 'Paiement accepté') {
            $this->generateDownloadLinksAndSendEmail($order);
        }
    }

    private function generateDownloadLinksAndSendEmail(Order $order): void
    {
        try {
            // Vérifier si les liens n'existent pas déjà
            if ($order->getDownloadLinks()->isEmpty()) {
                // Générer les liens de téléchargement
                $downloadLinks = $this->downloadLinkManager->generateDownloadLinksForOrder($order);
                
                // Envoyer l'email avec les liens
                $this->emailService->sendDownloadLinksEmail($order, $downloadLinks);
                
                $this->logger->info('Download links generated and email sent', [
                    'orderId' => $order->getId(),
                    'userEmail' => $order->getCustomer()->getEmail(),
                    'linksCount' => count($downloadLinks)
                ]);
            }
        } catch (\Exception $e) {
            $this->logger->error('Failed to generate download links', [
                'orderId' => $order->getId(),
                'error' => $e->getMessage()
            ]);
        }
    }
}
