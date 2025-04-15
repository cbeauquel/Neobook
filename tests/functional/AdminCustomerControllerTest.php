<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class AdminCustomerControllerTest extends FunctionalTestCase
{
    public function testShouldListCustomers(): void
    {
        $this->get('/admin/customer');
        self::assertResponseRedirects('/login');

        $this->login();
        $this->get('/admin/customer');
        $this->assertResponseStatusCodeSame(403, 'Access Denied');

        $this->loginAdmin();
        $this->get('/admin/customer');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Liste des clients');
    }
}
