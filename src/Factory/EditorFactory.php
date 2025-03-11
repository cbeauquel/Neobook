<?php

namespace App\Factory;

use App\Entity\Editor;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Editor>
 */
final class EditorFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function createCustomEditors(): void
    {
        self::createSequence([
            ['name' => 'De Borée', 'logo' => 'deboree-678cdd6ce61b3.png'],
            ['name' => 'Amphora', 'logo' => 'amphora.jpg'],
            ['name' => 'Cairn', 'logo' => 'cairn.jpg'],
            ['name' => 'Ella', 'logo' => 'ella.jpg'],
            ['name' => 'Marivole', 'logo' => 'marivole-678cd5c609a88.png'],
        ]);
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
            'description' => self::faker()->text(200),
            'logo' => self::faker()->imageUrl(640, 480, 'business'),
            'name' => self::faker()->company(),
            'status' => self::faker()->boolean(),
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
