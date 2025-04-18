<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class CustomerAccountControllerTest extends FunctionalTestCase
{
    public function testShouldIsUpCustomerAccount(): void
    {
        $this->login();
        $this->get('/account');
        self::assertSelectorTextSame('h1', 'Compte de John');
    }

    public function testShouldShowFeedbacks(): void
    {
        $this->login();
        $this->get('/account');
        // $this->client->clickLink('Gérer');
        // $this->client->followRedirect();
        self::assertResponseIsSuccessful();
    }
}
