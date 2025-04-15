<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class AdminCategoryControllerTest extends FunctionalTestCase
{
    /**
    * @dataProvider categoryProvider
    */
    public function testCategoryDisplaysCategoriesTable(string $name, int $id): void
    {
        $this->loginAdmin();
        $this->get('/admin/category');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('H1', 'Liste des catégories');
        self::assertAnySelectorTextSame('td', $name);
    }

    /**
     * @return array<int, list<int|string>>
     */
    public function categoryProvider(): array
    {
        return [
            ['Classiques', 1],
            ['Roman noir', 2],
            ['Romance', 3],
            ['Fantasy, SF', 4],
            ['Roman historique', 5],
            ['Théâtre', 6],
            ['Contes et nouvelles', 7],
            ['Poésie', 8],
            ['Jeunesse', 9],
            ['Essais, témoignage', 10],
            ['Biographies', 11],
            ['Sport et bien-être', 12],
        ];
    }

    public function testCategoryAddCategory(): void
    {
        $this->loginAdmin();
        $this->get('/admin/category');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('a.add p', 'Ajouter une catégorie');
        $this->client->clickLink('Ajouter une catégorie');
        $this->client->submitForm('Envoyer', [
            'category[name]' => 'Nouvelle catégorie'
        ]);
        $this->client->followRedirects();
        $this->get('/admin/category');
        self::assertAnySelectorTextSame('td', 'Nouvelle catégorie');
    }

    public function testCategoryEditCategory(): void
    {
        $categoryId = $this->getLastCategoryId();
        $this->loginAdmin();
        $this->get('/admin/category');
        $this->assertResponseIsSuccessful();
        $this->client->clickLink('Modifier ' . $categoryId);
        $this->client->submitForm('Envoyer', [
            'category[name]' => 'Catégorie modifiée'
        ]);
        $this->client->followRedirects();
        $this->get('/admin/category');
        self::assertAnySelectorTextSame('td', 'Catégorie modifiée');
    }

    public function testShouldRemoveCategory(): void
    {
        $categoryId = $this->getLastCategoryId();
        $this->loginAdmin();
        $this->get('/admin/category');
        $this->assertResponseIsSuccessful();
        $this->client->submitForm($categoryId);
        $this->client->followRedirects();
        $this->get('/admin/category');
        self::assertAnySelectorTextNotContains('td', 'Catégorie modifiée');
    }
}
