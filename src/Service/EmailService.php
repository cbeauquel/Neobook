<?php

namespace App\Service;

use App\Entity\Order;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class EmailService
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly Environment $twig,
        private readonly DownloadLinkManagerService $downloadLinkManager
    ) {
    }

    /**
    * Génère les liens de téléchargement dans l'e-mail pour une commande validée
    * @param array<mixed> $downloadLinks
    * @param \App\Entity\Order $order
    */
    public function sendDownloadLinksEmail(Order $order, array $downloadLinks): void
    {
        $customer = $order->getCustomer();
        
        // Préparer les données pour le template
        $downloadData = [];
        foreach ($downloadLinks as $downloadLink) {
            $format = $downloadLink->getFormat();
            $book = $format->getBook();
            
            $downloadData[] = [
                'bookTitle' => $book->getTitle(),
                'formatType' => $format->getType()->getName(),
                'downloadUrl' => $this->downloadLinkManager->generateDownloadUrl($downloadLink),
                'maxDownloads' => $downloadLink->getMaxDownloads(),
                'expiresAt' => $downloadLink->getExpiresAt()
            ];
        }

        // Créer l'email
        $email = (new Email())
            ->from('no-reply@neobook.fr')
            ->to($customer->getEmail())
            ->subject('Vos liens de téléchargement - Commande N°' . $order->getId())
            ->html($this->twig->render('emails/download_links.html.twig', [
                'customer' => $customer,
                'order' => $order,
                'downloadData' => $downloadData
            ]));

        $this->mailer->send($email);
    }
}
