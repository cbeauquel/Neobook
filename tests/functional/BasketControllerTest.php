<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class BasketControllerTest extends FunctionalTestCase
{
    public function testShouldAddFormatInBasket(): void
    {
        $this->get('/book/1');
        $book = $this->getBookId('1');
        $parutionDate = $book->getParutionDate();
        $today = new \DateTime();
        if ($parutionDate < $today) {
            self::assertSelectorExists('input[name="format[]"]');
            $this->client->submitForm(
                'Ajouter au panier',
                ['format[0]' => '1'],
                'POST'
            );
            $session = $this->client->getRequest()->getSession();
            $sessionId = $session->getId();

            self::assertResponseRedirects('/basket/view');
            $this->get('/basket/view');

            $this->getLastBasket($sessionId);
            self::assertResponseIsSuccessful();

            ///test d'affichage du livre en panier
            self::assertSelectorExists('.format-1');
        } else {
            self::assertSelectorExists('p.aparaitre');
        }
    }

    public function testShouldRemoveBookOfBasket(): void
    {
        $this->get('/book/1');
        $session = $this->client->getRequest()->getSession();
        $sessionId = $session->getId();

        self::assertSelectorExists('input[name="format[]"]');
        $this->client->submitForm(
            'Ajouter au panier',
            ['format[0]' => '1'],
            'POST'
        );
        $this->get('/basket/view');
        self::assertSelectorExists('.format-1');

        $remove = $this->get('/basket/view')->selectButton('Supprimer')->form();
        $this->client->submit($remove);
      
        ///test d'affichage du livre en panier
        self::assertSelectorNotExists('.format-1');

        $bddBasket = $this->getLastBasket($sessionId);
        self::assertNull($bddBasket);
    }
}
