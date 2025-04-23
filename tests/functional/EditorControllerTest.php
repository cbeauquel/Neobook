<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class EditorControllerTest extends FunctionalTestCase
{
    /**
    * @dataProvider editorProvider
    */
    public function testEditorDisplaysBooks(string $name, int $id): void
    {
        $this->get('/editor/' . $id);
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('H1', $name);
        $nbBooksByEditor = $this->countBooksByEditor($id);
        self::assertSelectorCount($nbBooksByEditor, 'a.book-card');
    }

    /**
    * @return array<int, list<int|string>>
    */
    public function editorProvider(): array
    {
        return [
            ['De Borée', 1],
            ['Amphora', 2],
            ['Cairn', 3],
            ['Ella', 4],
            ['Marivole', 5],
        ];
    }
}
