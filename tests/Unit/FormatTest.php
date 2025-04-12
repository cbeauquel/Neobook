<?php

namespace App\Tests\Unit;

use App\Entity\Basket;
use App\Entity\Book;
use App\Entity\Format;
use App\Entity\Tva;
use App\Entity\Type;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    public function testIsTrue(): void
    {
        $typeTest = new Type();
        $tvaTest = new Tva();
        $bookTest = new Book();
        $basketTest = new Basket();
        $basketsTest = new ArrayCollection($elements = [$basketTest]);

        $formatTest = new Format();
        $formatTest->setISBN('9782812937767')
                   ->setDuration(10)
                   ->setWordsCount(25125)
                   ->setPagesCount(421)
                   ->setFileSize(2.1)
                   ->setFilePath('test.test')
                   ->setBookExtract('extractTest.test')
                   ->setType($typeTest)
                   ->setPriceHT('9.99')
                   ->setPriceTTC('10.49')
                   ->setTvaRate($tvaTest)
                   ->setBook($bookTest)
                   ->addBasket($basketTest)
                   ->setBaskets($basketsTest);

        $this->assertTrue($formatTest->getISBN() === '9782812937767');
        $this->assertTrue($formatTest->getDuration() === 10);
        $this->assertTrue($formatTest->getWordsCount() === 25125);
        $this->assertTrue($formatTest->getPagesCount() === 421);
        $this->assertTrue($formatTest->getFileSize() === 2.1);
        $this->assertTrue($formatTest->getFilePath() === 'test.test');
        $this->assertTrue($formatTest->getBookExtract() === 'extractTest.test');
        $this->assertTrue($formatTest->getType() === $typeTest);
        $this->assertTrue($formatTest->getPriceHT() === '9.99');
        $this->assertTrue($formatTest->getPriceTTC() === '10.49');
        $this->assertTrue($formatTest->getTvaRate() === $tvaTest);
        $this->assertTrue($formatTest->getBook() === $bookTest);
        $this->assertTrue($formatTest->getBaskets() === $basketsTest);
    }

    public function testIsFalse(): void
    {
        $typeTest = new Type();
        $tvaTest = new Tva();
        $bookTest = new Book();
        $basketTest = new Basket();
        $basketsTest = new ArrayCollection($elements = [$basketTest]);

        $formatTest = new Format();
        $formatTest->setISBN('9782812937767')
                   ->setDuration(10)
                   ->setWordsCount(25125)
                   ->setPagesCount(421)
                   ->setFileSize(2.1)
                   ->setFilePath('test.test')
                   ->setBookExtract('extractTest.test')
                   ->setType($typeTest)
                   ->setPriceHT('9.99')
                   ->setPriceTTC('10.49')
                   ->setTvaRate($tvaTest)
                   ->setBook($bookTest)
                   ->addBasket($basketTest)
                   ->setBaskets($basketsTest);

        $this->assertFalse($formatTest->getISBN() === '9782812937765');
        $this->assertFalse($formatTest->getDuration() === 18);
        $this->assertFalse($formatTest->getWordsCount() === 25127);
        $this->assertFalse($formatTest->getPagesCount() === 424);
        $this->assertFalse($formatTest->getFileSize() === 2.2);
        $this->assertFalse($formatTest->getFilePath() === 'testFalse.test');
        $this->assertFalse($formatTest->getBookExtract() === 'extractTestFalse.test');
        $this->assertFalse($formatTest->getType() === new Type());
        $this->assertFalse($formatTest->getPriceHT() === '9.95');
        $this->assertFalse($formatTest->getPriceTTC() === '10.45');
        $this->assertFalse($formatTest->getTvaRate() === new Tva());
        $this->assertFalse($formatTest->getBook() === new Book());
        $this->assertFalse($formatTest->getBaskets() === new ArrayCollection($elements = [$basketTest]));
    }

    public function testIsEmpty(): void
    {
        $formatTest = new Format();

        $this->assertEmpty($formatTest->getISBN());
        $this->assertEmpty($formatTest->getDuration());
        $this->assertEmpty($formatTest->getWordsCount());
        $this->assertEmpty($formatTest->getPagesCount());
        $this->assertEmpty($formatTest->getFileSize());
        $this->assertEmpty($formatTest->getFilePath());
        $this->assertEmpty($formatTest->getBookExtract());
        $this->assertEmpty($formatTest->getType());
        $this->assertEmpty($formatTest->getPriceHT());
        $this->assertEmpty($formatTest->getPriceTTC());
        $this->assertEmpty($formatTest->getTvaRate());
    }
}
