<?php

namespace App\Factory;

use App\Entity\Contributor;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Contributor>
 */
final class ContributorFactory extends PersistentProxyObjectFactory
{
    private CONST CONTRIBUTOR_LASTNAMES = ['Jovnovic', 'Grelet', 'Vaissière', 'Shearer', 'Le Gloahec'];
    private CONST CONTRIBUTOR_FIRSTNAMES = ['Anne', 'Marcel', 'Jean-François', 'Lyonel', 'Françoise'];
    private CONST CONTRIBUTOR_PICTURES = ['img\contributeurs\bessou.jpg', 'img\contributeurs\grelet.jpg', 'img\contributeurs\jovanovic.jpg', 'img\contributeurs\legloahec.jpg', 'img\contributeurs\shearer.jpg', 'img\contributeurs\vaissierejf.jpg' ];
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
            'dateAdd' => self::faker()->dateTime(),
            'lastname' => self::faker()->randomElement(self::CONTRIBUTOR_LASTNAMES),
            'photo' => self::faker()->randomElement(self::CONTRIBUTOR_PICTURES),
            'status' => 1,
            'firstname' => self::faker()->randomElement(self::CONTRIBUTOR_FIRSTNAMES),
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
