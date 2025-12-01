<?php

namespace App\Controller;

use App\Service\DownloadLinkManagerService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class DownloadController extends AbstractController
{
    public function __construct(
        private readonly DownloadLinkManagerService $downloadLinkManager,
        private readonly LoggerInterface $logger
    ) {
    }

    #[Route('/download/{token}', name: 'app_download_file', methods: ['GET'])]
    public function download(string $token): Response
    {
        // Rechercher le lien de téléchargement
        $downloadLink = $this->downloadLinkManager->findByToken($token);
        
        if (!$downloadLink) {
            $this->logger->warning('Download attempt with invalid token', ['token' => $token]);
            throw new NotFoundHttpException('Lien de téléchargement introuvable.');
        }

        // Vérifier la validité du lien
        if (!$downloadLink->isValidForDownload()) {
            $this->logger->warning('Download attempt with invalid link', [
                'token' => $token,
                'downloadCount' => $downloadLink->getDownloadCount(),
                'maxDownloads' => $downloadLink->getMaxDownloads(),
                'isActive' => $downloadLink->isActive(),
                'expiresAt' => $downloadLink->getExpiresAt()?->format('Y-m-d H:i:s')
            ]);
            
            throw new AccessDeniedHttpException('Ce lien de téléchargement a expiré ou n\'est plus valide.');
        }

        // Vérifier que le fichier existe
        if (!$this->downloadLinkManager->fileExists($downloadLink)) {
            $this->logger->error('File not found for download', [
                'token' => $token,
                'filePath' => $this->downloadLinkManager->getFilePath($downloadLink)
            ]);
            
            throw new NotFoundHttpException('Fichier introuvable.');
        }

        // Traiter le téléchargement (incrémenter le compteur)
        if (!$this->downloadLinkManager->processDownload($downloadLink)) {
            throw new AccessDeniedHttpException('Impossible de traiter le téléchargement.');
        }

        // Préparer la réponse de téléchargement
        $filePath = $this->downloadLinkManager->getFilePath($downloadLink);
        $format = $downloadLink->getFormat();
        $book = $format->getBook();
        
        // Générer un nom de fichier propre
        $fileName = $this->sanitizeFileName($book->getTitle()) . '_' . $format->getType()->getName();
        $fileName .= $format->getType()->getName() === 'EPUB' ? '.epub' : '.mp3';

        // Logger le téléchargement réussi
        $this->logger->info('Successful download', [
            'token' => $token,
            'user' => $downloadLink->getCustomer()->getEmail(),
            'book' => $book->getTitle(),
            'format' => $format->getType()->getName(),
            'downloadCount' => $downloadLink->getDownloadCount(),
            'remainingDownloads' => $downloadLink->getMaxDownloads() - $downloadLink->getDownloadCount()
        ]);

        // Créer la réponse de téléchargement
        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );

        // Définir les headers appropriés selon le type de fichier
        if ($format->getType()->getName() === 'EPUB') {
            $response->headers->set('Content-Type', 'application/epub+zip');
        } else {
            $response->headers->set('Content-Type', 'audio/mpeg');
        }

        // Headers de sécurité
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate');

        return $response;
    }

    /**
     * Nettoie le nom de fichier pour éviter les problèmes
     */
    private function sanitizeFileName(string $filename): string
    {
        // Supprimer les accents et caractères spéciaux
        $filename = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $filename);
        
        // Remplacer les espaces et caractères spéciaux par des underscores
        $filename = preg_replace('/[^a-zA-Z0-9\-_]/', '_', $filename);
        
        // Supprimer les underscores multiples
        $filename = preg_replace('/_+/', '_', (string) $filename);
        
        // Supprimer les underscores en début et fin
        $filename = trim((string) $filename, '_');
        
        return $filename;
    }
}
