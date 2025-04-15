<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class AdminBookControllerTest extends FunctionalTestCase
{
    public function testShouldListBooks(): void
    {
        $this->get('/admin/book');
        self::assertResponseRedirects('/login');

        $this->login();
        $this->get('/admin/book');
        $this->assertResponseStatusCodeSame(403, 'Access Denied');

        $this->loginAdmin();
        $this->get('/admin/book');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Liste des livres');
        $this->assertSelectorCount(11, 'tr');
        $this->client->clickLink('Ajouter un livre');
        $this->get('/admin/book/add');
        $this->assertSelectorTextSame('h1', 'Ajouter un livre');
    }
}
