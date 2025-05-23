<?php

namespace App\Factory;

use App\Entity\BoSkCo;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BoSkCo>
 */
final class BoSkCoFactory extends PersistentProxyObjectFactory
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
        return BoSkCo::class;
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
            // 'book' => BookFactory::random(),
            'contributor' => ContributorFactory::random(),
            'skill' => SkillFactory::first(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(BoSkCo $boSkCo): void {})
        ;
    }
}
