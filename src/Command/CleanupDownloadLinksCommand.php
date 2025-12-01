<?php

namespace App\Command;

use App\Service\DownloadLinkManager;
use App\Service\DownloadLinkManagerService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:cleanup-download-links',
    description: 'Désactive les liens de téléchargement expirés'
)]
class CleanupDownloadLinksCommand extends Command
{
    public function __construct(private readonly DownloadLinkManagerService $downloadLinkManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $deactivatedCount = $this->downloadLinkManager->deactivateExpiredLinks();
        
        $io->success("$deactivatedCount liens de téléchargement expirés ont été désactivés.");
        
        return Command::SUCCESS;
    }
}
