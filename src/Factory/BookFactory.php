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
            'bookUpdate' => self::faker()->dateTime(),
            'cover' => self::faker()->randomElement(self::BOOK_COVER),
            'creationDate' => self::faker()->dateTime(),
            'authors' => AuthorFactory::randomRange(1, 2),
            'categories' => CategoryFactory::randomRange(1,3),
            'formats' => FormatFactory::randomRange(1, 2),
            'editor' => EditorFactory::random(),
            'genre' => self::faker()->domainWord(),
            'parutionDate' => self::faker()->dateTime(),
            'status' => 1,
            'summary' => self::faker()->text(),
            'title' => self::faker()->randomElement(self::BOOK_TITLE),
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
