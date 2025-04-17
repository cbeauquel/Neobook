<?php

namespace App\Tests\Unit;

use App\Entity\Order;
use App\Entity\Payment;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    public function testIsTrue(): void
    {
        $orderTest = new Order();
        $ordersTest = new ArrayCollection($elements = [$orderTest]);

        $paymentTest = new Payment();
        $paymentTest->setMode('Paypal')
                    ->setOrders($ordersTest);

        $this->assertTrue($paymentTest->getMode() === 'Paypal');
        $this->assertTrue($paymentTest->getOrders() === $ordersTest);
    }

    public function testIsFalse(): void
    {
        {
            $orderTest = new Order();
            $ordersTest = new ArrayCollection($elements = [$orderTest]);
    
            $paymentTest = new Payment();
            $paymentTest->setMode('Paypal')
                        ->setOrders($ordersTest);
    
            $this->assertFalse($paymentTest->getMode() === 'Carte bancaire');
            $this->assertFalse($paymentTest->getOrders() === new ArrayCollection($elements = [$orderTest]));
        }
    }

    public function testIsEmpty(): void
    {
        $paymentTest = new Payment();
        $this->assertEmpty($paymentTest->getMode());
    }

    public function testAddOrder(): void
    {
        $payment = new Payment();
        $order = new Order();

        $this->assertCount(0, $payment->getOrders());

        $payment->addOrder($order);

        $this->assertCount(1, $payment->getOrders());
        $this->assertTrue($payment->getOrders()->contains($order));
        $this->assertSame($payment, $order->getPaymentMode());
    }

    public function testAddOrderTwice(): void
    {
        $payment = new Payment();
        $order = new Order();

        $payment->addOrder($order);
        $payment->addOrder($order); // doublon

        $this->assertCount(1, $payment->getOrders());
    }

    public function testRemoveOrder(): void
    {
        $payment = new Payment();
        $order = new Order();

        $payment->addOrder($order);
        $payment->removeOrder($order);

        $this->assertCount(0, $payment->getOrders());
        $this->assertNull($order->getPaymentMode());
    }
}
