<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Basket;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Contributor;
use App\Entity\Editor;
use App\Entity\Feedback;
use App\Entity\Format;
use App\Entity\Order;
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

    protected function loginAdmin(string $email = 'c.beauquel@neobook.fr'): void
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

    protected function getCurrentUser(string $email = 'beauquelc@yahoo.fr'): User
    {
        return $this->service(EntityManagerInterface::class)->getRepository(User::class)->findOneByEmail($email);
    }

    protected function getTbrId(string|int $id, User $user): ToBeRead
    {
        return $this->service(EntityManagerInterface::class)->getRepository(ToBeRead::class)->findByBookAndUserId($id, $user);
    }

    protected function getLastBasket(string $sessionId): ?Basket
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Basket::class)->findBasketByUserToken($sessionId);
    }

    /**
     * @return Format[]
     */
    protected function getFormatsOfCustomerOrder(User $user): array
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Format::class)->findByOrderStatus($user);
    }

    protected function countFormatsOnBookShelf(User $user): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Order::class)->countByUserIdAndByStatus($user);
    }
    /**
     * @param Format[] $formatsId
     * @param User $user
     */
    protected function countCustomerFeedbacks(User $user, array $formatsId): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Feedback::class)->countByUserId($user, $formatsId);
    }
    
    protected function countBooksByCategory(int $id): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Category::class)->countByCategory($id);
    }
    
    protected function countBooksByContributor(int $id): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Contributor::class)->countByContributor($id);
    }
        
    protected function countBooksByEditor(int $id): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Editor::class)->countByEditor($id);
    }
               
    protected function countFeedbacksByUser(User $user): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Feedback::class)->countByUser($user);
    }

    protected function getLastOrderId(User $user): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Order::class)->findLastOrderId($user);
    }

    protected function getLastBasketId(User $user): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Basket::class)->findLastBasketId($user);
    }
    
    protected function getLastFeedbackId(User $user): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Feedback::class)->findLastFeedbackId($user);
    }

    protected function getLastCategoryId(): string
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Category::class)->findLastCategoryId();
    }

    protected function getLastContributorId(): string
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Contributor::class)->findLastContributorId();
    }

    protected function getLastEditorId(): string
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Editor::class)->findLastEditorId();
    }

    protected function getFormatTest(): Format
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Format::class)->findFormatTest();
    }

    protected function getFormatForFeedbackTest(User $user): int
    {
        return $this->service(EntityManagerInterface::class)->getRepository(Format::class)->findFormatForFeedbackTest($user);
    }
}
