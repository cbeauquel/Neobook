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
            'ISBN' => self::faker()->text(13),
            'duration' => self::faker()->randomNumber(),
            'filePath' => self::faker()->text(255),
            'fileSize' => self::faker()->randomFloat(),
            'pagesCount' => self::faker()->randomNumber(),
            'priceHT' => self::faker()->randomFloat(),
            'priceTTC' => self::faker()->randomFloat(),
            'tvaRate' => TvaFactory::new(),
            'type' => TypeFactory::new(),
            'wordsCount' => self::faker()->randomNumber(),
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
