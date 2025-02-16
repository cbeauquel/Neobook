<?php 
namespace App\Twig;

use App\Service\FooterService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalVariables extends AbstractExtension implements GlobalsInterface
{
    private FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    public function getGlobals(): array
    {
        return [
            'footerLinks' => $this->footerService->getFooterLinks(),
        ];
    }
}