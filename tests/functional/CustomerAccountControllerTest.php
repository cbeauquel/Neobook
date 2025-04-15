<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class CustomerAccountControllerTest extends FunctionalTestCase
{
    public function testShouldIsUpCustomerAccount(): void
    {
        $this->login();
        $this->get('/account');
        self::assertAnySelectorTextSame('h1', 'Compte de John');
        self::assertAnySelectorTextSame('article.book-card h2', 'Mes commandes');
        self::assertAnySelectorTextSame('article.book-card h2', 'Bibliothèque');
        self::assertAnySelectorTextSame('article.book-card h2', 'Commentaires et évaluations');
        self::assertAnySelectorTextSame('article.book-card h2', 'Informations personnelles');
        self::assertAnySelectorTextSame('a.account-content span', 'preview');
        self::assertAnySelectorTextSame('a.account-content span', 'bookmark');
        self::assertAnySelectorTextSame('a.account-content span', 'visibility');
        self::assertAnySelectorTextSame('a.account-content span', 'person_edit');
        self::assertAnySelectorTextSame('a.account-content span', 'logout');
    }

    public function testShouldShowInvoices(): void
    {
        $this->login();
        $this->get('/account');
        $this->client->clickLink('Consulter');
        $this->get('/invoices');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextSame('H2', 'Mes factures');
    }

    public function testShouldShowBookShelf(): void
    {
        $this->login();
        $this->get('/account');
        $this->client->clickLink('Gérer');
        $this->get('/bookshelf');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextSame('H1', 'Ma bibliothèque');
    }

    public function testShouldShowfeedbacks(): void
    {
        $this->login();
        $this->get('/account');
        $this->client->clickLink('Vos commentaires');
        $this->get('/myFeedbacks');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextSame('H1', 'Commentaires de John');
    }

    public function testShouldEditAccount(): void
    {
        $user = $this->getCurrentUser();
        $idUser = $user->getId();
        $this->login();
        $this->get('/account');
        $this->client->clickLink('Compléter');
        $this->get('/edit/' . $idUser);
        self::assertResponseIsSuccessful();
        $this->client->submitForm('Envoyer', [
            'customer[firstname]' => 'NewFirstname',
        ]);
        self::assertResponseRedirects('/account');
        $this->get('/account');
        self::assertAnySelectorTextSame('h1', 'Compte de NewFirstname');
        $this->get('/edit/' . $idUser);
        $this->client->submitForm('Envoyer', [
            'customer[firstname]' => 'John',
        ]);
        self::assertResponseRedirects('/account');
        $this->get('/account');
        self::assertAnySelectorTextSame('h1', 'Compte de John');
    }
}
