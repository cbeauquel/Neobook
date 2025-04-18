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

        // return match ($this) {
        // self::CDI => $translator->trans('contract_status.CDI.label', locale: $locale),
        // self::CDD => $translator->trans('contract_status.CDD.label', locale: $locale),
        // self::Interim => $translator->trans('contract_status.Interim.label', locale: $locale),
        // self::Freelance => $translator->trans('contract_status.Freelance.label', locale: $locale),
        // self::Apprentice => $translator->trans('contract_status.Apprentice.label', locale: $locale),
        // self::Intern => $translator->trans('contract_status.Intern.label', locale: $locale),
        //};
    }
}
