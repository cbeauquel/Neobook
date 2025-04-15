<?php

namespace App\Tests\Unit;

use App\Entity\Basket;
use App\Entity\Format;
use App\Entity\Order;
use App\Entity\User;
use App\Enum\BasketStatus;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    public function testIsTrue(): void
    {
        $userTest = new User();
        $formatTest = new Format();
        $formatsTest = new ArrayCollection($elements = [$formatTest]);
        $orderIdTest = new Order();

        $basketTest = new Basket();
        $basketTest->setCustomer($userTest)
                   ->setUserToken('cpjfm1o2otbkvdjaliun82ta63Test')
                   ->setFormats($formatsTest)
                   ->setTotalHT('19.99')
                   ->setTotalTTC('26.99')
                   ->setStatus(BasketStatus::IN_PROGRESS)
                   ->setOrderId($orderIdTest);

        $this->assertTrue($basketTest->getCustomer() === $userTest);
        $this->assertTrue($basketTest->getUserToken() === 'cpjfm1o2otbkvdjaliun82ta63Test');
        $this->assertTrue($basketTest->getFormats() === $formatsTest);
        $this->assertTrue($basketTest->getTotalHT() === '19.99');
        $this->assertTrue($basketTest->getTotalTTC() === '26.99');
        $this->assertTrue($basketTest->getStatus() === BasketStatus::IN_PROGRESS);
        $this->assertTrue($basketTest->getOrderId() === $orderIdTest);
    }

    public function testIsFalse(): void
    {
        $userTest = new User();
        $formatTest = new Format();
        $formatsTest = new ArrayCollection($elements = [$formatTest]);
        $orderIdTest = new Order();

        $basketTest = new Basket();
        $basketTest->setCustomer($userTest)
                   ->setUserToken('cpjfm1o2otbkvdjaliun82ta63Test')
                   ->setFormats($formatsTest)
                   ->setTotalHT('19.99')
                   ->setTotalTTC('26.99')
                   ->setStatus(BasketStatus::IN_PROGRESS);

        $this->assertFalse($basketTest->getCustomer() === new User());
        $this->assertFalse($basketTest->getUserToken() === 'cpjfm1o2otbkvdjaliun82ta63False');
        $this->assertFalse($basketTest->getFormats() === new ArrayCollection($elements = [$formatTest]));
        $this->assertFalse($basketTest->getTotalHT() === '17.99');
        $this->assertFalse($basketTest->getTotalTTC() === '24.99');
        $this->assertFalse($basketTest->getStatus() === BasketStatus::ABORTED);
        $this->assertFalse($basketTest->getOrderId() === $orderIdTest);
    }

    public function testIsEmpty(): void
    {
        $basketTest = new Basket();
        $this->assertEmpty($basketTest->getCustomer());
        $this->assertEmpty($basketTest->getUserToken());
        $this->assertEmpty($basketTest->getTotalHT());
        $this->assertEmpty($basketTest->getTotalTTC());
    }

    public function testRemoveFormat(): void
    {
        $formatTest = new Format();
        $basketTest = new Basket();

        $basketTest->addFormat($formatTest); // gère aussi le setBasket() normalement
        $this->assertCount(1, $basketTest->getFormats());
    
        $basketTest->removeFormat($formatTest);
    
        $this->assertCount(0, $basketTest->getFormats());
    }
}
