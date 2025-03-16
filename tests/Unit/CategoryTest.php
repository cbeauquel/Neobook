<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\Category;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

class CategoryTest extends TestCase
{
    public function testIsTrue(): void
    {
        $bookTest = new Book();
        $booksTest = new ArrayCollection($elements = [$bookTest]);

        $categoryTest = new Category();
        $categoryTest->setName('categoryTest');
        $categoryTest->addBook($bookTest);
        $categoryTest->setBooks($booksTest);

        $this->assertTrue($categoryTest->getName() === 'categoryTest');
        $this->assertTrue($categoryTest->getBooks() === $booksTest);

        $categoryTest->removeBook($bookTest);
        $this->assertEmpty($categoryTest->getBooks());
    }

    public function testIsFalse(): void
    {
        $bookTest = new Book();
        $booksTest = new ArrayCollection($elements = [$bookTest]);
        
        $categoryTest = new Category();
        $categoryTest->setName('categoryTest');
        $categoryTest->addBook($bookTest);
        $categoryTest->setBooks($booksTest);

        $this->assertFalse($categoryTest->getName() === 'categoryTestFalse');
        $this->assertFalse($categoryTest->getBooks() === new ArrayCollection($elements = [$bookTest]));

        $categoryTest->removeBook(new Book());
        $this->assertTrue($categoryTest->getBooks() === $booksTest);

    }
    
    public function testIsEmpty(): void
    {
        $categoryTest = new Category();
        $this->assertEmpty($categoryTest->getName());
        $this->assertEmpty($categoryTest->getBooks());
    }
}
