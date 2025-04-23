<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class QuiSommesNousControllerTest extends FunctionalTestCase
{
    public function testDisplaysQuiSommesNous(): void
    {
        $this->get('/qui-sommes-nous');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('H1', 'Qui sommes-nous ?');
    }

    public function testDisplaysConditions(): void
    {
        $this->get('/conditions-utilisation');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('H1', 'Conditions d\'utilisation');
    }

    public function testDisplaysLegals(): void
    {
        $this->get('/mentions-legales');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('H1', 'Mentions légales et hébergement');
    }
}
