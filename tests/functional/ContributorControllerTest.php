<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class ContributorControllerTest extends FunctionalTestCase
{
    /**
    * @dataProvider contributorProvider
    */
    public function testContributorDisplaysBooks(string $firstname, string $lastname, int $id): void
    {
        $this->get('/contributor/' . $id);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('H1', $firstname . ' ' . $lastname);
        $nbBooksByContributor = $this->countBooksByContributor($id);
        self::assertSelectorCount($nbBooksByContributor, 'a.book-card');
        self::assertSelectorTextSame('div.brick p', 'Auteur');
    }

    /**
    * @return array<int, list<int|string>>
    */
    public function contributorProvider(): array
    {
        return [
            ['Lyonel', 'Shearer', 1],
            ['Françoise', 'Le Gloahec', 2],
            ['Jean-François', 'Vaissière', 3],
            ['Anne', 'Jovanovic', 4],
            ['Yves', 'Carchon', 5],
            ['Marcel', 'Grelet', 6],
            ['Bernard', 'Bessou', 7],
            ['Philippe', 'Grandcoin', 8],
            ['Christian', 'Laborie', 9],
        ];
    }
}
