<?php

namespace App\Twig;

use App\Service\FooterService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalVariables extends AbstractExtension implements GlobalsInterface
{
    public function __construct(private readonly FooterService $footerService)
    {
    }

    public function getGlobals(): array
    {
        return [
            'footerLinks' => $this->footerService->getFooterLinks(),
        ];
    }
}
