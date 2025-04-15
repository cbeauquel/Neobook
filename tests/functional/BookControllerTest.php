<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class BookControllerTest extends FunctionalTestCase
{
    public function testShouldShowBook(): void
    {
        $today = new \DateTime();
        $book = $this->getBookId($today);
        $bookId = $book->getId();
        $this->get('/book/' . $bookId);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $book->getTitle());
        $this->assertSelectorExists('.cover-big');
        $this->assertSelectorTextSame('.book-skill', 'Auteur :');
        $this->assertSelectorExists('a.brick');
    }

    public function testShouldAddToBeRead(): void
    {
        $today = new \DateTime();
        $book = $this->getBookId($today);
        $bookId = $book->getId();
        $user = $this->getCurrentUser();
        $userId = $user->getId();
        $this->get('/book/' . $bookId);
        $this->client->clickLink('bookmark_heart');
        $this->client->followRedirect();
        $this->login();
        $this->assertResponseIsSuccessful();
        $this->get('/book/' . $bookId);
        $this->client->submitForm(
            'bookmark_heart',
            ['to_be_read[book]' => $bookId,
             'to_be_read[customer]' => $userId,
             'to_be_read[status]' => 'à lire'
            ],
            'POST'
        );
        $this->assertResponseRedirects('/account');
        $this->get('/account');
        $this->assertSelectorTextSame('h1', 'Compte de John');
        $this->assertAnySelectorTextSame('h2', 'Ma PAL');
        $this->assertSelectorExists('img.cover');
        $this->assertSelectorTextSame('.book-title', $book->getTitle());
    }

    public function testShouldRemoveToBeRead(): void
    {
        $this->login();
        $this->get('/account');
        $this->assertAnySelectorTextSame('h2', 'Ma PAL');
        $today = new \DateTime();
        $book = $this->getBookId($today);
        $bookId = $book->getId();
        $user = $this->getCurrentUser();
        $tbr = $this->getTbrId($bookId, $user);
        $this->assertSelectorExists('img.cover');
        $this->assertSelectorTextSame('.book-title', $book->getTitle());
        $this->get('/remove/' . $tbr->getId());
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorNotExists('.book-title', $book->getTitle());
    }
}
