<?php

namespace App\Factory;

use App\Entity\Contributor;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Contributor>
 */
final class ContributorFactory extends PersistentProxyObjectFactory
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
        return Contributor::class;
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
            'createdAt' => self::faker()->dateTime(),
            'firstname' => self::faker()->text(255),
            'lastname' => self::faker()->text(255),
            'photo' => self::faker()->text(255),
            'slug' => self::faker()->text(255),
            'status' => self::faker()->boolean(),
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Contributor $contributor): void {})
        ;
    }
}
