<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class AdminBookControllerTest extends FunctionalTestCase
{
    public function testShouldListBooks(): void
    {
        $this->get('/admin/book');
        self::assertResponseRedirects('/login');

        $this->login();
        $this->get('/admin/book');
        $this->assertResponseStatusCodeSame(403, 'Access Denied');

        $this->loginAdmin();
        $this->get('/admin/book');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Liste des livres');
        $this->assertSelectorCount(11, 'tr');
        $this->client->clickLink('Ajouter un livre');
        $this->assertSelectorTextSame('h1', 'Ajouter un livre');
    }
    
    public function testShouldAddBook(): void
    {
        $this->loginAdmin();

        $photoPath = realpath(dirname(__DIR__, 2) . '/assets/img/livres/une-fleur-pour-l-eternite.jpg');
        $uploadedFile = new UploadedFile(
            $photoPath,
            'une-fleur-pour-l-eternite.jpg',
            'image/jpeg',
            null,
            true // true pour "test mode" : fichier réel déjà présent, pas déplacé
        );

        $this->get('/admin/book');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Liste des livres');
        $this->client->request('GET', '/admin/book/add', [], [], [
            'HTTP_X_TEST_TYPE' => 'webTestCase'
        ]);
        $this->assertSelectorTextSame('h1', 'Ajouter un livre');
        $this->assertSelectorExists('#book_BoSkCos_0_contributor');
        $this->client->submitForm(
            'Envoyer',
            [
            'book[BoSkCos][0][contributor]' => '1',
            'book[BoSkCos][0][skill]' => '1',
            'book[editor]' => '1',
            'book[categories]' => ['1'],
            'book[title]' => 'Nouveau titre de livre',
            'book[cover]' => $uploadedFile,
            'book[summary]' => 'Description du nouveau livre qui a pour auteur Lyonel Shearer',
            'book[genre]' => 'genre-du-nouveau-livre',
            'book[parutionDate]' => '2026-01-01',
            'book[status]' => '1',
            'book[keyWords]' => ['1'],
            'book[formats][0][ISBN]' => '9999999999999',
            'book[formats][0][priceHT]' => '9.99',
            'book[formats][0][priceTTC]' => '10.04',
            'book[formats][0][tvaRate]' => '1',
            'book[formats][0][duration]' => '240',
            'book[formats][0][wordsCount]' => '9999',
            'book[formats][0][pagesCount]' => '240',
            'book[formats][0][fileSize]' => '2.5',
            'book[formats][0][filePath]' => 'test.fr/test.epub',
            'book[formats][0][bookExtract]' => 'test.fr/extract.epub',
            'book[formats][0][type]' => '1'
            ]
        );
        $this->get('/admin/book');
        self::assertAnySelectorTextSame('td', 'Nouveau titre de livre');
    }

    public function testShouldEditBook(): void
    {
        $this->loginAdmin();
        $photoPath = realpath(dirname(__DIR__, 2) . '/assets/img/livres/une-fleur-pour-l-eternite.jpg');
        $uploadedFile = new UploadedFile(
            $photoPath,
            'une-fleur-pour-l-eternite.jpg',
            'image/jpeg',
            null,
            true // true pour "test mode" : fichier réel déjà présent, pas déplacé
        );

        $crawler = $this->get('/admin/book');
        $bookId = $this->getLastBookId();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Liste des livres');
        $link = $crawler->filter('a.upd-' . $bookId)->link();
        $this->client->click($link);
        $this->assertSelectorTextSame('h1', 'Ajouter un livre');
        $this->client->submitForm(
            'Envoyer',
            [
            'book[BoSkCos][0][contributor]' => '1',
            'book[BoSkCos][0][skill]' => '1',
            'book[editor]' => '1',
            'book[categories]' => ['1'],
            'book[title]' => 'Titre du livre modifié',
            'book[cover]' => $uploadedFile,
            'book[summary]' => 'Description du nouveau livre qui a pour auteur Lyonel Shearer',
            'book[genre]' => 'genre-du-nouveau-livre',
            'book[parutionDate]' => '2026-01-01',
            'book[status]' => '1',
            'book[keyWords]' => ['1'],
            'book[formats][0][ISBN]' => '9999999999999',
            'book[formats][0][priceHT]' => '9.99',
            'book[formats][0][priceTTC]' => '10.04',
            'book[formats][0][tvaRate]' => '1',
            'book[formats][0][duration]' => '240',
            'book[formats][0][wordsCount]' => '9999',
            'book[formats][0][pagesCount]' => '240',
            'book[formats][0][fileSize]' => '2.5',
            'book[formats][0][filePath]' => 'test.fr/test.epub',
            'book[formats][0][bookExtract]' => 'test.fr/extract.epub',
            'book[formats][0][type]' => '1'
            ]
        );
        $this->get('/admin/book');
        self::assertAnySelectorTextSame('td', 'Titre du livre modifié');
    }


    public function testShouldRemoveBook(): void
    {
        $bookId = $this->getLastBookId();
        $this->loginAdmin();
        $this->get('/admin/book');
        $this->assertResponseIsSuccessful();
        $this->client->submitForm($bookId);
        $this->get('/admin/book');
        self::assertAnySelectorTextNotContains('td', 'Titre du livre modifié');
    }
}
