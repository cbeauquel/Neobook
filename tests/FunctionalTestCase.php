<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Basket;
use App\Entity\Book;
use App\Entity\Format;
use App\Entity\ToBeRead;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

abstract class FunctionalTestCase extends WebTestCase
{
    protected KernelBrowser $client;


    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->service(EntityManagerInterface::class);
    }

    /**
     * @template T
     * @param class-string<T> $id
     */
    protected function service(string $id): object
    {
        return $this->client->getContainer()->get($id);
    }

    /**
     * @param string[] $parameters
     */
    protected function get(string $uri, array $parameters = []): Crawler
    {
        return $this->client->request('GET', $uri, $parameters);
    }

    protected function login(string $email = 'beauquelc@yahoo.fr'): void
    {
        $user = $this->service(EntityManagerInterface::class)->getRepository(User::class)->findOneByEmail($email);

        $this->client->loginUser($user);
    }

    protected function getBook(string $id): Book
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Book::class)->findOneByid($id);
    }

    protected function getBookId(DateTime $today): Book
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Book::class)->findNewByid($today);
    }

    protected function getFormatId(Book $book): Format
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Format::class)->findOneByBookId($book);
    }

    protected function getUser(string $email): User
    {
        return $this->service(EntityManagerInterface::class)->getRepository(User::class)->findOneByEmail($email);
    }

    protected function getTbrId(string $id, User $user): ToBeRead
    {
        return $this->service(EntityManagerInterface::class)->getRepository(ToBeRead::class)->findByBookAndUserId($id, $user);
    }

    protected function getLastBasket(string $sessionId): ?Basket
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Basket::class)->findBasketByUserToken($sessionId);
    }
}
