<?php

namespace App\Factory;

use App\Entity\Book;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Book>
 */
final class BookFactory extends PersistentProxyObjectFactory
{
    private CONST BOOK_TITLE = ['L\'armée sans Prince 2 - Catholique et Royale', 'La Terre éphémère', 'Une fleur pour l\'éternité', 'Le goût subtil du venin', 'Derrière la fumée', 'Jean Jaurès, n\'oublions pas ses combats'];
    private CONST BOOK_COVER = ['img/livres/derriere-la-fumee.jpg', 'img/livres/l-armee-sans-prince-tome-2-catholique-et-royale.jpg', 'img/livres/la-terre-ephemere-tome-5-osmose.jpg', 'img/livres/la-terre-ephemere-tome-5-osmose.jpg', 'img/livres/petite-histoire-de-jean-jaures.jpg', 'img/livres/une-fleur-pour-l-eternite.jpg'];
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
        return Book::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'cover' => self::faker()->randomElement(self::BOOK_COVER),
            'genre' => self::faker()->text(255),
            'parutionDate' => self::faker()->dateTime(),
            'status' => self::faker()->boolean(),
            'summary' => self::faker()->text(),
            'title' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Book $book): void {})
        ;
    }
}
