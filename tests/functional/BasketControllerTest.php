<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class BasketControllerTest extends FunctionalTestCase
{
    public function testShouldAddFormatInBasket(): void
    {
        $today = new \DateTime();
        $book = $this->getBookId($today);
        $bookId = $book->getId();
        $format = $this->getFormatId($book);
        $formatId = $format->getId();
        $this->get('/book/' . $bookId);
        $parutionDate = $book->getParutionDate();
        if ($parutionDate < $today) {
            self::assertSelectorExists('input[name="format[]"]');
            $this->client->submitForm(
                'Ajouter au panier',
                ['format[0]' => $formatId],
                'POST'
            );
            $session = $this->client->getRequest()->getSession();
            $sessionId = $session->getId();

            self::assertResponseRedirects('/basket/view');
            $this->get('/basket/view');

            $this->getLastBasket($sessionId);
            self::assertResponseIsSuccessful();

            ///test d'affichage du livre en panier
            self::assertSelectorExists('.format-' . $formatId);
        } else {
            self::assertSelectorExists('p.aparaitre');
        }
    }

    public function testShouldRemoveBookOfBasket(): void
    {
        $today = new \DateTime();
        $book = $this->getBookId($today);
        $bookId = $book->getId();
        $format = $this->getFormatId($book);
        $formatId = $format->getId();
        $this->get('/book/' . $bookId);
        $session = $this->client->getRequest()->getSession();
        $sessionId = $session->getId();

        self::assertSelectorExists('input[name="format[]"]');
        $this->client->submitForm(
            'Ajouter au panier',
            ['format[0]' => $formatId],
            'POST'
        );
        $this->get('/basket/view');
        self::assertSelectorExists('.format-' . $formatId);

        $remove = $this->get('/basket/view')->selectButton('Supprimer')->form();
        $this->client->submit($remove);
      
        ///test d'affichage du livre en panier
        self::assertSelectorNotExists('.format-' . $formatId);

        $bddBasket = $this->getLastBasket($sessionId);
        self::assertNull($bddBasket);
    }
}
