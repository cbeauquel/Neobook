<?php

declare(strict_types=1);

namespace App\Tests;

use App\Doctrine\Repository\BookRepository;
use App\Entity\Basket;
use App\Entity\Book;
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

    protected function getBookId(string $bookId): Book
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Book::class)->findOneByid($bookId);
    }

    protected function getLastBasket(string $sessionId): ?Basket
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Basket::class)->findBasketByUserToken($sessionId);
    }
}
