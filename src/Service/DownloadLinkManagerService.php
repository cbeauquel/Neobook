<?php

namespace App\Service;

use App\Entity\DownloadLink;
use App\Entity\Order;
use App\Repository\DownloadLinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class DownloadLinkManagerService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DownloadLinkRepository $downloadLinkRepository,
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir
    ) {
    }

    /**
     * Génère les liens de téléchargement pour une commande validée
     * @return DownloadLink[]
     */
    public function generateDownloadLinksForOrder(Order $order): array
    {
        $downloadLinks = [];
        
        // Récupérer tous les formats de la commande
        $formats = $order->getBasket()->getFormats();
        
        foreach ($formats as $format) {
            $downloadLink = new DownloadLink();
            $downloadLink
                ->setCustomer($order->getCustomer())
                ->setFormat($format)
                ->setOrder($order)
                ->generateToken()
                ->setMaxDownloads(5) // Paramétrable
                ->setExpiresAt((new \DateTime())->modify('+30 days')) // Expire après 30 jours
                ->setIsActive(true);
            
            $this->entityManager->persist($downloadLink);
            $downloadLinks[] = $downloadLink;
        }
        
        $this->entityManager->flush();
        
        return $downloadLinks;
    }

    /**
     * Trouve un lien de téléchargement par son token
     */
    public function findByToken(string $token): ?DownloadLink
    {
        return $this->downloadLinkRepository->findOneBy(['token' => $token]);
    }

    /**
     * Valide et traite un téléchargement
     */
    public function processDownload(DownloadLink $downloadLink): bool
    {
        if (!$downloadLink->isValidForDownload()) {
            return false;
        }

        $downloadLink->incrementDownloadCount();
        
        // Si c'est le dernier téléchargement autorisé, désactiver le lien
        if ($downloadLink->getDownloadCount() >= $downloadLink->getMaxDownloads()) {
            $downloadLink->setIsActive(false);
        }

        $this->entityManager->flush();
        
        return true;
    }

    /**
     * Génère l'URL de téléchargement
     */
    public function generateDownloadUrl(DownloadLink $downloadLink): string
    {
        return '/download/' . $downloadLink->getToken();
    }

    /**
     * Obtient le chemin physique du fichier
     */
    public function getFilePath(DownloadLink $downloadLink): string
    {
        $format = $downloadLink->getFormat();
        return $this->projectDir . '/assets/files/formats/' . $format->getFilePath();
    }

    /**
     * Vérifie si un fichier existe
     */
    public function fileExists(DownloadLink $downloadLink): bool
    {
        return file_exists($this->getFilePath($downloadLink));
    }

    /**
     * Obtient tous les liens actifs d'un utilisateur
     * @return DownloadLink[]
     */
    public function getActiveDownloadLinksForUser(\App\Entity\User $user): array
    {
        return $this->downloadLinkRepository->findBy([
            'customer' => $user,
            'isActive' => true
        ]);
    }

    /**
     * Désactive tous les liens expirés (à exécuter via une commande cron)
     */
    public function deactivateExpiredLinks(): int
    {
        $expiredLinks = $this->downloadLinkRepository->createQueryBuilder('dl')
            ->where('dl.expiresAt < :now')
            ->andWhere('dl.isActive = true')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();

        $count = 0;
        foreach ($expiredLinks as $link) {
            $link->setIsActive(false);
            $count++;
        }

        $this->entityManager->flush();
        
        return $count;
    }

    /**
     * Réactive un lien (pour support client)
     */
    public function reactivateLink(DownloadLink $downloadLink, int $additionalDownloads = 1): void
    {
        $downloadLink->setIsActive(true);
        $downloadLink->setMaxDownloads($downloadLink->getMaxDownloads() + $additionalDownloads);
        
        $this->entityManager->flush();
    }
}
