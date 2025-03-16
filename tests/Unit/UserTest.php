<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Entity\Basket;
use App\Entity\Feedback;
use App\Entity\Order;
use App\Entity\ToBeRead;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

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
                 ->setOptin('1')
                 ->setPreference('Test')
                 ->setBaskets($basketsTest)
                 ->setOrders($ordersTest)
                 ->setNickName('firstLastnameTest')
                 ->setFeedbacks($feedbacksTest)
                 ->setVerified('1')
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
                 ->setOptin('1')
                 ->setPreference('Test')
                 ->setBaskets($basketsTest)
                 ->setOrders($ordersTest)
                 ->setNickName('firstLastnameTest')
                 ->setFeedbacks($feedbacksTest)
                 ->setVerified('1')
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
        $this->assertEmpty($userTest->getBaskets());
        $this->assertEmpty($userTest->getOrders());
        $this->assertEmpty($userTest->getNickName());
        $this->assertEmpty($userTest->getFeedbacks());
        $this->assertEmpty($userTest->isVerified());
        $this->assertEmpty($userTest->getToBeReads());
    }
}
