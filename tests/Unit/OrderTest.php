<?php

namespace App\Tests\Unit;

use App\Entity\Basket;
use App\Entity\Order;
use App\Entity\OrderStatus;
use App\Entity\Payment;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testIsTrue(): void
    {
        $userTest = new User();
        $basketTest = new Basket();
        $paymentModeTest = new Payment();
        $orderStatusTest = new OrderStatus();

        $orderTest = new Order();
        $orderTest->setNewCustomer(true)
                  ->setCustomer($userTest)
                  ->setStatus($orderStatusTest)
                  ->setPaymentMode($paymentModeTest)
                  ->setBasket($basketTest)
                  ->setTotalHT('19.99')
                  ->setTotalTTC('26.99');

        $this->assertTrue($orderTest->isNewCustomer() === true);
        $this->assertTrue($orderTest->getCustomer() === $userTest);
        $this->assertTrue($orderTest->getStatus() === $orderStatusTest);
        $this->assertTrue($orderTest->getPaymentMode() === $paymentModeTest);
        $this->assertTrue($orderTest->getBasket() === $basketTest);
        $this->assertTrue($orderTest->getTotalHT() === '19.99');
        $this->assertTrue($orderTest->getTotalTTC() === '26.99');
    }

    public function testIsFalse(): void
    {
        $userTest = new User();
        $basketTest = new Basket();
        $paymentModeTest = new Payment();
        $orderStatusTest = new OrderStatus();

        $orderTest = new Order();
        $orderTest->setNewCustomer(true)
                  ->setCustomer($userTest)
                  ->setStatus($orderStatusTest)
                  ->setPaymentMode($paymentModeTest)
                  ->setBasket($basketTest)
                  ->setTotalHT('19.99')
                  ->setTotalTTC('26.99');

        $this->assertFalse($orderTest->isNewCustomer() === false);
        $this->assertFalse($orderTest->getCustomer() === new User());
        $this->assertFalse($orderTest->getStatus() === new OrderStatus());
        $this->assertFalse($orderTest->getPaymentMode() === new Payment());
        $this->assertFalse($orderTest->getBasket() === new Basket());
        $this->assertFalse($orderTest->getTotalHT() === '17.99');
        $this->assertFalse($orderTest->getTotalTTC() === '24.99');
    }

    public function testIsEmpty(): void
    {
        $orderTest = new order();
        $this->assertEmpty($orderTest->isNewCustomer());
        $this->assertEmpty($orderTest->getCustomer());
        $this->assertEmpty($orderTest->getStatus());
        $this->assertEmpty($orderTest->getPaymentMode());
        $this->assertEmpty($orderTest->getBasket());
        $this->assertEmpty($orderTest->getTotalHT());
        $this->assertEmpty($orderTest->getTotalTTC());
    }
}
