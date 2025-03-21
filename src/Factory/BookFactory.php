<?php

namespace App\Factory;

use App\Entity\Book;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Book>
 */
final class BookFactory extends PersistentProxyObjectFactory
{
    private const array BOOK_TITLE = ['L\'armée sans Prince 2 - Catholique et Royale', 'La Terre éphémère', 'Une fleur pour l\'éternité', 'Le goût subtil du venin', 'Derrière la fumée', 'Jean Jaurès, n\'oublions pas ses combats'];
    private const array BOOK_COVER = ['derriere-la-fumee.jpg', 'l-armee-sans-prince-tome-2-catholique-et-royale.jpg', 'la-terre-ephemere-tome-5-osmose.jpg', 'la-terre-ephemere-tome-5-osmose.jpg', 'petite-histoire-de-jean-jaures.jpg', 'une-fleur-pour-l-eternite.jpg'];
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
     * @return array<mixed>
     *
     */
    protected function defaults(): array
    {
        $publishedAt = self::faker()->dateTimeBetween('-1 years', '+1years');
        return [
            'cover' => self::faker()->randomElement(self::BOOK_COVER),
            'genre' => self::faker()->slug($nbWords = 1, $variableNbWords = true),
            'parutionDate' => $publishedAt,
            'status' => self::faker()->boolean($chanceOfGettingTrue = 90),
            'summary' => self::faker()->text(),
            'title' => self::faker()->randomElement(self::BOOK_TITLE),
            'categories' => CategoryFactory::randomRange(1, 4),
            'editor' => EditorFactory::random(),
            'boSkCos' => BoSkCoFactory::new()->range(1, 4),
            'keyWords' => KeyWordFactory::new()->range(1, 5),
            'formats' => FormatFactory::new()->range(1, 2),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Book $book): void {})
        ;
    }
}
