<?php

namespace App\Tests\Unit;

use App\Entity\Basket;
use App\Entity\Feedback;
use App\Entity\Order;
use App\Entity\ToBeRead;
use App\Entity\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue(): void
    {
        $dateTime = new DateTime();
        $basketTest = new Basket();
        $basketsTest = new ArrayCollection($elements = [$basketTest]);
        $orderTest = new Order();
        $ordersTest = new ArrayCollection($elements = [$orderTest]);
        $feedbackTest = new Feedback();
        $feedbacksTest = new ArrayCollection($elements = [$feedbackTest]);
        $toBeReadTest = new ToBeRead();
        $toBeReadsTest = new ArrayCollection($elements = [$toBeReadTest]);

        $userTest = new User();
        $userTest->setEmail('test@test.com')
                 ->setRoles(['ROLE_USER'])
                 ->setPassword('password')
                 ->setFirstname('firstnameTest')
                 ->setLastname('lastnameTest')
                 ->setLastVisitDate($dateTime)
                 ->setOptin(true)
                 ->setPreference('Test')
                 ->setBaskets($basketsTest)
                 ->setOrders($ordersTest)
                 ->setNickName('firstLastnameTest')
                 ->setFeedbacks($feedbacksTest)
                 ->setVerified(true)
                 ->setToBeReads($toBeReadsTest);

        $this->assertTrue($userTest->getEmail() === 'test@test.com');
        $this->assertTrue($userTest->getRoles() === ['ROLE_USER']);
        $this->assertTrue($userTest->getPassword() === 'password');
        $this->assertTrue($userTest->getFirstname() === 'firstnameTest');
        $this->assertTrue($userTest->isOptin() === true);
        $this->assertTrue($userTest->getLastVisitDate() === $dateTime);
        $this->assertTrue($userTest->getPreference() === 'Test');
        $this->assertTrue($userTest->getBaskets() === $basketsTest);
        $this->assertTrue($userTest->getOrders() === $ordersTest);
        $this->assertTrue($userTest->getNickName() === 'firstLastnameTest');
        $this->assertTrue($userTest->getFeedbacks() === $feedbacksTest);
        $this->assertTrue($userTest->isVerified() === true);
        $this->assertTrue($userTest->getToBeReads() === $toBeReadsTest);
    }

    public function testIsFalse(): void
    {
        $dateTime = new DateTime();
        $basketTest = new Basket();
        $basketsTest = new ArrayCollection($elements = [$basketTest]);
        $orderTest = new Order();
        $ordersTest = new ArrayCollection($elements = [$orderTest]);
        $feedbackTest = new Feedback();
        $feedbacksTest = new ArrayCollection($elements = [$feedbackTest]);
        $toBeReadTest = new ToBeRead();
        $toBeReadsTest = new ArrayCollection($elements = [$toBeReadTest]);

        $userTest = new User();
        $userTest->setEmail('test@test.com')
                 ->setRoles(['ROLE_USER'])
                 ->setPassword('password')
                 ->setFirstname('firstnameTest')
                 ->setLastname('lastnameTest')
                 ->setLastVisitDate($dateTime)
                 ->setOptin(true)
                 ->setPreference('Test')
                 ->setBaskets($basketsTest)
                 ->setOrders($ordersTest)
                 ->setNickName('firstLastnameTest')
                 ->setFeedbacks($feedbacksTest)
                 ->setVerified(true)
                 ->setToBeReads($toBeReadsTest);

        $this->assertFalse($userTest->getEmail() === 'test@false.com');
        $this->assertFalse($userTest->getRoles() === ['ROLE_ADMIN']);
        $this->assertFalse($userTest->getPassword() === 'falsePassword');
        $this->assertFalse($userTest->getFirstname() === 'falseFirstnameTest');
        $this->assertFalse($userTest->isOptin() === false);
        $this->assertFalse($userTest->getLastVisitDate() === new DateTime());
        $this->assertFalse($userTest->getPreference() === 'false');
        $this->assertFalse($userTest->getBaskets() === new ArrayCollection($elements = [$basketTest]));
        $this->assertFalse($userTest->getOrders() === new ArrayCollection($elements = [$orderTest]));
        $this->assertFalse($userTest->getNickName() === 'firstLastnameFalseTest');
        $this->assertFalse($userTest->getFeedbacks() === new ArrayCollection($elements = [$feedbackTest]));
        $this->assertFalse($userTest->isVerified() === false);
        $this->assertFalse($userTest->getToBeReads() === new ArrayCollection($elements = [$toBeReadTest]));
    }

    
    public function testIsEmpty(): void
    {
        $userTest = new User();
        $this->assertEmpty($userTest->getEmail());
        $this->assertEmpty($userTest->getPassword());
        $this->assertEmpty($userTest->getFirstname());
        $this->assertEmpty($userTest->isOptin());
        $this->assertEmpty($userTest->getLastVisitDate());
        $this->assertEmpty($userTest->getPreference());
        $this->assertEmpty($userTest->getNickName());
        $this->assertEmpty($userTest->isVerified());
    }

    public function testAddBasket(): void
    {
        $user = new User();
        $basket = new Basket();

        $this->assertCount(0, $user->getBaskets());

        $user->addBasket($basket);

        $this->assertCount(1, $user->getBaskets());
        $this->assertTrue($user->getBaskets()->contains($basket));
        $this->assertSame($user, $basket->getCustomer());
    }

    public function testAddBasketTwice(): void
    {
        $user = new User();
        $basket = new Basket();

        $user->addBasket($basket);
        $user->addBasket($basket); // doublon

        $this->assertCount(1, $user->getBaskets());
    }

    public function testRemoveBasket(): void
    {
        $user = new User();
        $basket = new Basket();

        $user->addBasket($basket);
        $user->removeBasket($basket);

        $this->assertCount(0, $user->getBaskets());
        $this->assertNull($basket->getCustomer());
    }

    public function testSetBaskets(): void
    {
        $user = new User();
        $basket1 = new Basket();
        $basket2 = new Basket();

        $collection = new ArrayCollection([$basket1, $basket2]);

        $user->setBaskets($collection);

        $this->assertCount(2, $user->getBaskets());
        $this->assertSame($collection, $user->getBaskets());
    }

    public function testAddFeedback(): void
    {
        $user = new User();
        $feedback = new Feedback();

        $this->assertCount(0, $user->getFeedbacks());

        $user->addFeedback($feedback);

        $this->assertCount(1, $user->getFeedbacks());
        $this->assertTrue($user->getFeedbacks()->contains($feedback));
        $this->assertSame($user, $feedback->getNickName());
    }

    public function testAddFeedbackTwice(): void
    {
        $user = new User();
        $feedback = new Feedback();

        $user->addFeedback($feedback);
        $user->addFeedback($feedback); // doublon

        $this->assertCount(1, $user->getFeedbacks());
    }

    public function testRemoveFeedback(): void
    {
        $user = new User();
        $feedback = new Feedback();

        $user->addFeedback($feedback);
        $user->removeFeedback($feedback);

        $this->assertCount(0, $user->getFeedbacks());
        $this->assertNull($feedback->getNickName());
    }

    public function testSetFeedbacks(): void
    {
        $user = new User();
        $feedback1 = new Feedback();
        $feedback2 = new Feedback();

        $collection = new ArrayCollection([$feedback1, $feedback2]);

        $user->setFeedbacks($collection);

        $this->assertCount(2, $user->getFeedbacks());
        $this->assertSame($collection, $user->getFeedbacks());
    }

    public function testAddToBeRead(): void
    {
        $user = new User();
        $toBeRead = new ToBeRead();

        $this->assertCount(0, $user->getToBeReads());

        $user->addToBeRead($toBeRead);

        $this->assertCount(1, $user->getToBeReads());
        $this->assertTrue($user->getToBeReads()->contains($toBeRead));
        $this->assertSame($user, $toBeRead->getCustomer());
    }

    public function testAddToBeReadTwice(): void
    {
        $user = new User();
        $toBeRead = new ToBeRead();

        $user->addToBeRead($toBeRead);
        $user->addToBeRead($toBeRead); // doublon

        $this->assertCount(1, $user->getToBeReads());
    }

    public function testRemoveToBeRead(): void
    {
        $user = new User();
        $toBeRead = new ToBeRead();

        $user->addToBeRead($toBeRead);
        $user->removeToBeRead($toBeRead);

        $this->assertCount(0, $user->getToBeReads());
        $this->assertNull($toBeRead->getCustomer());
    }

    public function testSetToBeReads(): void
    {
        $user = new User();
        $item1 = new ToBeRead();
        $item2 = new ToBeRead();

        $collection = new ArrayCollection([$item1, $item2]);

        $user->setToBeReads($collection);

        $this->assertCount(2, $user->getToBeReads());
        $this->assertSame($collection, $user->getToBeReads());
    }
}
