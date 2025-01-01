<?php

namespace App\Factory;

use App\Entity\Editor;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Editor>
 */
final class EditorFactory extends PersistentProxyObjectFactory
{
    private CONST EDITOR_NAME = ['Ella Editions', 'CAIRN', 'Amphora', 'De Borée'];
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
        return Editor::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'dateAdd' => self::faker()->dateTime(),
            'description' => self::faker()->text(),
            'logo' => self::faker()->imageUrl(),
            'name' => self::faker()->randomElement(self::EDITOR_NAME),
            'status' => 1,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Editor $editor): void {})
        ;
    }
}
