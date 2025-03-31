<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class BookControllerTest extends FunctionalTestCase
{
    public function testShouldShowBook(): void
    {
        $this->get('/book/1');
        $book = $this->getBookId('1');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $book->getTitle());
        $this->assertSelectorExists('.cover-big');
        $this->assertSelectorTextSame('h1', $book->getTitle());
        $this->assertSelectorExists('div.brick > span.material-symbols-outlined');
        $this->assertSelectorTextSame('.book-skill', 'Auteur :');
        $this->assertSelectorExists('a.brick');
    }

    public function testShouldAddToBeRead(): void
    {
        $this->get('/book/1');
        $this->client->clickLink('bookmark_heart');
        $this->client->followRedirect();
        $this->login();
        $this->assertResponseIsSuccessful();

        $this->get('/book/1');
        $this->client->submitForm(
            'bookmark_heart',
            ['to_be_read[book]' => '1',
             'to_be_read[customer]' => '2',
             'to_be_read[status]' => 'à lire'
            ],
            'POST'
        );
        $this->assertResponseRedirects('/account');
    }
}
