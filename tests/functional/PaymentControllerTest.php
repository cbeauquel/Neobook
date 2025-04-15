<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class PaymentControllerTest extends FunctionalTestCase
{
    public function testShouldRedirectToPayment(): void
    {
        $this->login();
        $user = $this->getCurrentUser();
        $orderId = $this->getLastOrderId($user);
        $this->get('/order/view/' . $orderId);
        $this->assertResponseIsSuccessful();
        $this->client->clickLink('Je paye et télécharge mon livre');
        $this->get('/payplug/pay/' . $orderId);
        $this->client->followRedirects();
        self::assertResponseRedirects();
    }
}
