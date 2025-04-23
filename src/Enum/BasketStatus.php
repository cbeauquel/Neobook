<?php

namespace App\Enum;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum BasketStatus: string implements TranslatableInterface
{
    case IN_PROGRESS = 'En cours';
    case TRANSFORMED = 'Transformé';
    case ABORTED = 'Abandonné';


    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans($this->name, locale: $locale);
    }
}
