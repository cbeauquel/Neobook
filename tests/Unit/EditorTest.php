<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\Editor;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class EditorTest extends TestCase
{
    public function testIsTrue(): void
    {
        $bookTest = new Book();
        $booksTest = new ArrayCollection($elements = [$bookTest]);

        $editorTest = new Editor();
        $editorTest->setName('Editest')
                   ->setLogo('test.jpg')
                   ->setDescription('description de test')
                   ->setStatus(true)
                   ->addBook($bookTest)
                   ->setBooks($booksTest);

        $this->assertTrue($editorTest->getName() === 'Editest');
        $this->assertTrue($editorTest->getLogo() === 'test.jpg');
        $this->assertTrue($editorTest->getDescription() === 'description de test');
        $this->assertTrue($editorTest->isStatus() === true);
        $this->assertTrue($editorTest->getBooks() === $booksTest);
    }

    public function testIsFalse(): void
    {
        $bookTest = new Book();
        $booksTest = new ArrayCollection($elements = [$bookTest]);

        $editorTest = new Editor();
        $editorTest->setName('Editest')
                   ->setLogo('test.jpg')
                   ->setDescription('description de test')
                   ->setStatus(true)
                   ->addBook($bookTest)
                   ->setBooks($booksTest);

        $this->assertFalse($editorTest->getName() === 'EditestFalse');
        $this->assertFalse($editorTest->getLogo() === 'testFalse.jpg');
        $this->assertFalse($editorTest->getDescription() === 'description de test false');
        $this->assertFalse($editorTest->isStatus() === false);
        $this->assertFalse($editorTest->getBooks() === new ArrayCollection($elements = [$bookTest]));
    }

    public function testIsEmpty(): void
    {
        $editorTest = new Editor();
        $this->assertEmpty($editorTest->getName());
        $this->assertEmpty($editorTest->getLogo());
        $this->assertEmpty($editorTest->getDescription());
        $this->assertEmpty($editorTest->isStatus());
    }
}
