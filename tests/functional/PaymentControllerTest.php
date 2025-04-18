<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Service\PayPlugService;
use App\Tests\FunctionalTestCase;
use Payplug\Resource\Payment;

final class PaymentControllerTest extends FunctionalTestCase
{
    public function testShouldRedirectToPayment(): void
    {
        $payment = new class() extends Payment {
            public object $hosted_payment;
            public function __construct()
            {
                $this->hosted_payment = (object)[
                    'payment_url' => 'https://fake.payplug.com/payment/12345'
                ];
            }
        };
            
        $mockPayPlug = $this->createMock(PayPlugService::class);
        $mockPayPlug
            ->method('createPayment')
            ->willReturn($payment);
        static::getContainer()->set(PayPlugService::class, $mockPayPlug);

        $this->login();
        $user = $this->getCurrentUser();
        $orderId = $this->getLastOrderId($user);
        $this->get('/payplug/pay/' . $orderId);
        // ✅ Vérifie la redirection
        $this->assertResponseRedirects('https://fake.payplug.com/payment/12345');
    }

    public function testShouldFailedToRedirectToPayment(): void
    {
        $payment = new class() extends Payment {
            public object $hosted_payment;
            public function __construct()
            {
                $this->hosted_payment = (object)[
                    'payment_url' => 'testfail'
                ];
            }
        };
            
        $mockPayPlug = $this->createMock(PayPlugService::class);
        $mockPayPlug
            ->method('createPayment')
            ->willReturn($payment);
        static::getContainer()->set(PayPlugService::class, $mockPayPlug);

        $this->login();
        $user = $this->getCurrentUser();
        $orderId = $this->getLastOrderId($user);
        $this->get('/payplug/pay/' . $orderId);
        // ✅ Vérifie la redirection
        $this->assertResponseStatusCodeSame(302);
    }
}
