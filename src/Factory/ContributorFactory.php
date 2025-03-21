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

    public static function createCustomContributors(): void
    {
        self::createSequence([
            ['firstname' => 'Lyonel', 'lastname' => 'Shearer', 'photo' => 'shearer.jpg'],
            ['firstname' => 'Françoise', 'lastname' => 'Le Gloahec', 'photo' => 'legloahec.jpg'],
            ['firstname' => 'Jean-François', 'lastname' => 'Vaissière', 'photo' => 'vaissierejf.jpg'],
            ['firstname' => 'Anne', 'lastname' => 'Jovanovic', 'photo' => 'jovanovic.jpg'],
            ['firstname' => 'Yves', 'lastname' => 'Carchon', 'photo' => 'carchon.jpg'],
            ['firstname' => 'Marcel', 'lastname' => 'Grelet', 'photo' => 'grelet.jpg'],
            ['firstname' => 'Bernard', 'lastname' => 'Bessou', 'photo' => 'bessou.jpg'],
            ['firstname' => 'Philippe', 'lastname' => 'Grandcoin', 'photo' => 'grandcoin.jpg'],
            ['firstname' => 'Christian', 'lastname' => 'Laborie', 'photo' => 'laborie.jpg'],
        ]);
    }

    public static function class(): string
    {
        return Contributor::class;
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
            'bio' => self::faker()->text(),
            'firstname' => self::faker()->text(255),
            'lastname' => self::faker()->text(255),
            'photo' => self::faker()->text(255),
            'status' => self::faker()->boolean(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this->afterInstantiate(function (Contributor $contributor): void {
            $slug = strtolower($contributor->getFirstname() . '-' . $contributor->getLastname());
            $slug = str_replace(' ', '-', $slug); // Remplace les espaces par des tirets
            $slug = preg_replace('/[^a-z0-9\-]/', '', $slug); // Supprime les caractères spéciaux
            $contributor->setSlug($slug);
        });
    }
}
