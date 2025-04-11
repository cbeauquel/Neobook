<?php

namespace App\Factory;

use App\Entity\Format;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Format>
 */
final class FormatFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Format::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     * @return array<mixed>
     */
    protected function defaults(): array
    {
        return [
            'ISBN' => self::faker()->isbn13(),
            'duration' => self::faker()->randomNumber($nbDigits = 2, $strict = false),
            'filePath' => self::faker()->text(255),
            'fileSize' => self::faker()->randomFloat($nbMaxDecimals = 2, $min = 0.1, $max = 30),
            'pagesCount' => self::faker()->randomNumber($nbDigits = 3, $strict = false),
            'priceHT' => self::faker()->randomFloat($nbMaxDecimals = 2, $min = 2.99, $max = 29.99),
            'priceTTC' => self::faker()->randomFloat($nbMaxDecimals = 2, $min = 2.99, $max = 29.99),
            'wordsCount' => self::faker()->randomNumber($nbDigits = 5, $strict = false),
            'type' => TypeFactory::random(),
            'tvaRate' => TvaFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (Format $format): void {
                $priceTTC = 0.0;
                $priceHT = self::faker()->randomFloat($nbMaxDecimals = 2, $min = 2.99, $max = 29.99);
                $tvaRate = TvaFactory::random();
                $priceTTC = ($priceHT * $tvaRate->getTaux()) / 100;
            })
        ;
    }
}
