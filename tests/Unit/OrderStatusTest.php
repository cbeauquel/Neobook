<?php

namespace App\Tests\Unit;

use App\Entity\Order;
use App\Entity\OrderStatus;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class OrderStatusTest extends TestCase
{
    public function testIsTrue(): void
    {
        $orderTest = new Order();
        $ordersTest = new ArrayCollection($elements = [$orderTest]);

        $orderStatusTest = new OrderStatus();
        $orderStatusTest->setStatus('Paiement Accepté')
                        ->setOrders($ordersTest)
                        ->addOrder($orderTest);

        $this->assertTrue($orderStatusTest->getStatus() === 'Paiement Accepté');
        $this->assertTrue($orderStatusTest->getOrders() === $ordersTest);
    }

    public function testIsFalse(): void
    {
        {
            $orderTest = new Order();
            $ordersTest = new ArrayCollection($elements = [$orderTest]);
    
            $orderStatusTest = new OrderStatus();
            $orderStatusTest->setStatus('Paiement Accepté')
                            ->setOrders($ordersTest)
                            ->addOrder($orderTest);

    
            $this->assertFalse($orderStatusTest->getStatus() === 'Paiement Non Accepté');
            $this->assertFalse($orderStatusTest->getOrders() === new ArrayCollection($elements = [$orderTest]));
        }
    }

    public function testIsEmpty(): void
    {
        $orderStatusTest = new OrderStatus();
        $this->assertEmpty($orderStatusTest->getStatus());
    }

    public function testAddOrder(): void
    {
        $status = new OrderStatus();
        $order = new Order();

        $this->assertCount(0, $status->getOrders());

        $status->addOrder($order);

        $this->assertCount(1, $status->getOrders());
        $this->assertTrue($status->getOrders()->contains($order));
        $this->assertSame($status, $order->getStatus());
    }

    public function testAddOrderTwice(): void
    {
        $status = new OrderStatus();
        $order = new Order();

        $status->addOrder($order);
        $status->addOrder($order); // doublon

        $this->assertCount(1, $status->getOrders());
    }

    public function testRemoveOrder(): void
    {
        $status = new OrderStatus();
        $order = new Order();

        $status->addOrder($order);
        $status->removeOrder($order);

        $this->assertCount(0, $status->getOrders());
        $this->assertNull($order->getStatus());
    }
}
