<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class MainControllerTest extends FunctionalTestCase
{
    public function testShouldShowUpcoming(): void
    {
        $this->get('/');
        self::assertResponseIsSuccessful();
        //test d'affichage du nb de livres "à paraitre sur la page d'accueil"
        self::assertSelectorCount(6, 'article.upcoming');
    }

    public function testShouldShowNewBooks(): void
    {
        $crawler = $this->get('/');
        self::assertResponseIsSuccessful();
        ///test d'affichage du nb de livres "nouveautés" sur la page d'accueil"
        self::assertSelectorCount(12, 'article.newbooks');
        
        ///test d'affichage des étoiles
        // Vérifie qu'au moins une .stars-display est présente
        $this->assertGreaterThan(
            0,
            $crawler->filter('.stars-display')->count(),
            'Aucune moyenne étoile affichée dans .stars-display'
        );

        // Vérifie qu'au moins un bloc étoiles contient des <span class="star">
        $this->assertGreaterThan(
            0,
            $crawler->filter('.stars-display .star')->count(),
            'Aucune étoile (span.star) trouvée dans le HTML'
        );
    }

    public function testShouldShowCategories(): void
    {
        $this->get('/');
        self::assertResponseIsSuccessful();
        ///test d'affichage du nb de catégories sur la page d'accueil"
        self::assertSelectorCount(12, 'a.categories');
    }
}
