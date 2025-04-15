<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class CategoryControllerTest extends FunctionalTestCase
{
    /**
    * @dataProvider categoryProvider
    */
    public function testCategoryDisplaysBooks(string $name, int $id): void
    {
        $this->get('/category/' . $id);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('H1', $name);
        $nbBooksByCategory = $this->countBooksByCategory($id);
        self::assertSelectorCount($nbBooksByCategory, 'a.book-card');
    }

    /**
     * @return array<int, list<int|string>>
     */
    public function categoryProvider(): array
    {
        return [
            ['Classiques', 1],
            ['Roman noir', 2],
            ['Romance', 3],
            ['Fantasy, SF', 4],
            ['Roman historique', 5],
            ['Théâtre', 6],
            ['Contes et nouvelles', 7],
            ['Poésie', 8],
            ['Jeunesse', 9],
            ['Essais, témoignage', 10],
            ['Biographies', 11],
            ['Sport et bien-être', 12],
        ];
    }
}
