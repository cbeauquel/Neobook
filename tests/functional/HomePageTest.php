<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\Functional\FunctionalTestCase;

final class HomePageTest extends FunctionalTestCase
{
    public function testShouldShowUpcoming(): void
    {
        $this->get('/');
        self::assertResponseIsSuccessful();
        ///test d'affichage du nb de livres "à paraitre sur la page d'accueil"
        self::assertSelectorCount(6, 'article.upcoming');
    }

    public function testShouldShowNewBooks(): void
    {
        $this->get('/');
        self::assertResponseIsSuccessful();
        ///test d'affichage du nb de livres "nouveautés" sur la page d'accueil"
        self::assertSelectorCount(12, 'article.newbooks');
    }

    public function testShouldShowCategories(): void
    {
        $this->get('/');
        self::assertResponseIsSuccessful();
        ///test d'affichage du nb de catégories sur la page d'accueil"
        self::assertSelectorCount(12, 'a.categories');
    }
}
