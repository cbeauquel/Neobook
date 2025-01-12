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
     */
    protected function defaults(): array|callable
    {
        return [
            'ISBN' => self::faker()->isbn13(),
            'duration' => self::faker()->randomNumber($nbDigits = 2, $strict = true),
            'filePath' => self::faker()->filePath(),
            'fileSize' => self::faker()->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 30),
            'pagesCount' => self::faker()->randomNumber($nbDigits = 3, $strict = true),
            'priceHT' => self::faker()->randomFloat($nbMaxDecimals = 2, $min = 3, $max = 30),
            'wordsCount' => self::faker()->randomNumber($nbDigits = 4),
            'type' => TypeFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Format $format): void {})
        ;
    }
}
