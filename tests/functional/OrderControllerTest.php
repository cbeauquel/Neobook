<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class OrderControllerTest extends FunctionalTestCase
{
    public function testShouldAddOrder(): void
    {
        $this->login();
        $today = new \DateTime();
        $book = $this->getBookId($today);
        $bookId = $book->getId();
        $format = $this->getFormatId($book);
        $formatId = $format->getId();
        $this->get('/book/' . $bookId);
        $session = $this->client->getRequest()->getSession();
        $sessionId = $session->getId();
        $user = $this->getCurrentUser();
        self::assertSelectorExists('input[name="format[]"]');
        $this->client->submitForm(
            'Ajouter au panier',
            ['format[0]' => $formatId],
            'POST'
        );
        $this->get('/basket/view');
        self::assertSelectorExists('.format-' . $formatId);
        $this->client->clickLink('Je commande');
        $basketId = $this->getLastBasketId($user);
        $this->get('/order/add/' . $basketId);
        $this->client->followRedirects();
        $orderId = $this->getLastOrderId($user);
        $this->get('/order/view/' . $orderId);
        self::assertSelectorTextSame('h1', 'Ma commande');
    }

    // public function testIfDoubleOrder(): void
    // {
    //     $this->login();
    //     $user = $this->getCurrentUser();
    //     $basketId = $this->getLastBasketId($user);
    //     $orderId = $this->getLastOrderId($user);
    //     $this->get('/order/abort/' . $orderId);
    //     $this->get('/order/add/' . $basketId);
    //     $this->expectException(\RuntimeException::class);
    //     $this->expectExceptionMessage('Une commande a déjà été passée avec ce panier');
    // }

    public function testShouldAbortOrder(): void
    {
        $this->login();
        $user = $this->getCurrentUser();
        $orderId = $this->getLastOrderId($user);
        $this->get('/order/view/' . $orderId);
        $this->assertResponseIsSuccessful();
        $this->client->clickLink('Annuler la commande');
        $this->get('/order/abort/' . $orderId);
        $this->client->followRedirects();
    }
}
