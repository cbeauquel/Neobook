<?php

namespace App\Factory;

use App\Entity\Author;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Author>
 */
final class AuthorFactory extends PersistentProxyObjectFactory
{
    private CONST AUTHOR_NAMES = ['Jovnovic', 'Grelet', 'Vaissière', 'Shearer', 'Le Gloahec'];
    private CONST AUTHOR_FIRSTNAMES = ['Anne', 'Marcel', 'Jean-François', 'Lyonel', 'Françoise'];
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
        return Author::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'bio' => self::faker()->text(),
            'dateAdd' => self::faker()->dateTime(),
            'name' => self::faker()->randomElement(self::AUTHOR_NAMES),
            'photo' => self::faker()->text(255),
            'status' => 1,
            'surname' => self::faker()->randomElement(self::AUTHOR_FIRSTNAMES),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Author $author): void {})
        ;
    }
}
