<?php

namespace App\Tests;

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
        $this->assertEmpty($paymentTest->getOrders());
    }
}
