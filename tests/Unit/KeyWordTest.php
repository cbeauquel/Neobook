<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\KeyWord;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class KeyWordTest extends TestCase
{
    public function testIsTrue(): void
    {
        $bookTest = new Book();
        $booksTest = new ArrayCollection($elements = [$bookTest]);

        $KeyWordTest = new KeyWord();
        $KeyWordTest->setTag('tagTest');
        $KeyWordTest->addBook($bookTest);
        $KeyWordTest->setBooks($booksTest);

        $this->assertTrue($KeyWordTest->getTag() === 'tagTest');
        $this->assertTrue($KeyWordTest->getBooks() === $booksTest);
    }

    public function testIsFalse(): void
    {
        $bookTest = new Book();
        $booksTest = new ArrayCollection($elements = [$bookTest]);
        
        $KeyWordTest = new KeyWord();
        $KeyWordTest->setTag('tagTest');
        $KeyWordTest->addBook($bookTest);
        $KeyWordTest->setBooks($booksTest);

        $this->assertFalse($KeyWordTest->getTag() === 'tagTestFalse');
        $this->assertFalse($KeyWordTest->getBooks() === new ArrayCollection($elements = [$bookTest]));
    }
    
    public function testIsEmpty(): void
    {
        $KeyWordTest = new KeyWord();
        $this->assertEmpty($KeyWordTest->getTag());
        $this->assertEmpty($KeyWordTest->getBooks());
    }
}
