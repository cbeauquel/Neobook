<?php

namespace App\Factory;

use App\Entity\Type;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Type>
 */
final class TypeFactory extends PersistentProxyObjectFactory
{
    private CONST FORMAT_TYPE = ['eBook', 'Audio'];
    private CONST TYPE_IMG = ['book', 'headphones'];
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
        return Type::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->randomElement(self::FORMAT_TYPE),
            'typeImg' => self::faker()->randomElement(self::TYPE_IMG),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Type $type): void {})
        ;
    }
}
