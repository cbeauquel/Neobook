<?php

namespace App\Tests;

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
                        ->setOrders($ordersTest);

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
                            ->setOrders($ordersTest);
    
            $this->assertFalse($orderStatusTest->getStatus() === 'Paiement Non Accepté');
            $this->assertFalse($orderStatusTest->getOrders() === new ArrayCollection($elements = [$orderTest]));
        }
    }

    public function testIsEmpty(): void
    {
        $orderStatusTest = new OrderStatus();
        $this->assertEmpty($orderStatusTest->getStatus());
    }
}
