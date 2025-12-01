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
                    'payment_url' => 'https://fake.payplug.com/payment/pay_test_123',
                ];
            }
        };
        /** @phpstan-ignore-next-line */
        $payment->id = 'pay_test_123';
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
        $this->assertResponseRedirects('https://fake.payplug.com/payment/pay_test_123');
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
        /** @phpstan-ignore-next-line */
        $payment->id = 'pay_test_123';
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
