<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Basket;
use App\Entity\Payment;
use App\Entity\OrderStatus;
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
        $orderTest->setNewCustomer('1')
                  ->setCustomer($userTest)
                  ->setStatus($orderStatusTest)
                  ->setPaymentMode($paymentModeTest)
                  ->setBasket($basketTest)
                  ->setUserToken($basketTest)
                  ->setTotalHT('19.99')
                  ->setTotalTTC('26.99');

        $this->assertTrue($orderTest->isNewCustomer() === true);
        $this->assertTrue($orderTest->getCustomer() === $userTest);
        $this->assertTrue($orderTest->getStatus() === $orderStatusTest);
        $this->assertTrue($orderTest->getPaymentMode() ===$paymentModeTest);
        $this->assertTrue($orderTest->getBasket() === $basketTest);
        $this->assertTrue($orderTest->getUserToken() === $basketTest);
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
        $orderTest->setNewCustomer('1')
                  ->setCustomer($userTest)
                  ->setStatus($orderStatusTest)
                  ->setPaymentMode($paymentModeTest)
                  ->setBasket($basketTest)
                  ->setUserToken($basketTest)
                  ->setTotalHT('19.99')
                  ->setTotalTTC('26.99');

        $this->assertFalse($orderTest->isNewCustomer() === False);
        $this->assertFalse($orderTest->getCustomer() === new User());
        $this->assertFalse($orderTest->getStatus() === new OrderStatus());
        $this->assertFalse($orderTest->getPaymentMode() === new Payment());
        $this->assertFalse($orderTest->getBasket() === new Basket());
        $this->assertFalse($orderTest->getUserToken() === new Basket());
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
        $this->assertEmpty($orderTest->getUserToken());
        $this->assertEmpty($orderTest->getTotalHT());
        $this->assertEmpty($orderTest->getTotalTTC());
    }

}
