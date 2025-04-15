<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\Basket;
use App\Enum\BasketStatus;
use App\Tests\FunctionalTestCase;
use Doctrine\ORM\EntityManagerInterface;

final class BasketControllerTest extends FunctionalTestCase
{
    public function testShouldAddFormatInBasket(): void
    {
        $today = new \DateTime();
        $book = $this->getBookId($today);
        $bookId = $book->getId();
        $this->get('/book/' . $bookId);
        $format = $this->getFormatId($book);
        $formatId = $format->getId();
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
    
    public function testShouldShowBasket(): void
    {
        $this->login();
        $user = $this->getCurrentUser();
        $formatTest = $this->getFormatTest();
        $basket = new Basket();
        $basket->setCustomer($user)
               ->setUserToken('Test')
               ->addFormat($formatTest)
               ->setTotalHT($formatTest->getPriceHT())
               ->setTotalTTC($formatTest->getPriceTTC())
               ->setStatus(BasketStatus::IN_PROGRESS);
        $this->service(EntityManagerInterface::class)->persist($basket);
        $this->service(EntityManagerInterface::class)->flush($basket);

        $this->get('/basket/view');
        ///test d'affichage du livre en panier
        self::assertSelectorExists('.format-' . $formatTest->getId());
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

    public function testIfsessionBasketEmptyAndBddBasket(): void
    {
        $sessionBasket = [];
        $customer = $this->getCurrentUser();
        $bddBasket = new Basket();
        $bddBasket->setCustomer($customer);
        $this->service(EntityManagerInterface::class)->persist($bddBasket);
        $this->service(EntityManagerInterface::class)->flush($bddBasket);
        $this->login();
        $this->get('/basket/view');
        self::assertSelectorNotExists('table.table');
    }
}
