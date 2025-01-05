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
            'photo' => self::faker()->text(255),
            'status' => 1,
            'firstname' => self::faker()->randomElement(self::CONTRIBUTOR_FIRSTNAMES),
            'skill' => SkillFactory::random(),
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
