<?php

namespace App\Tests\Unit;

use App\Entity\Book;
use App\Entity\BoSkCo;
use App\Entity\Category;
use App\Entity\Editor;
use App\Entity\Feedback;
use App\Entity\Format;
use App\Entity\KeyWord;
use App\Entity\ToBeRead;
use App\Entity\Traits\TimestampableTrait;
use DateTime;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    use TimestampableTrait;


    public function testIsTrue(): void
    {
        $dateTimeTest = new DateTime();
        $toBeReadTest = new ToBeRead();
        $keyWordTest = new KeyWord();
        $categoryTest = new Category();
        $formatTest = new Format();
        $feedbackTest = new Feedback();
        $editorTest = new Editor();
        $boSkCoTest = new BoSkCo();
        $bookTest = new Book();
        $bookTest->setTitle('Test de titre')
                 ->setCover('test-de-cover.jpg')
                 ->setSummary('Je teste le summary, résumé du livre')
                 ->setGenre('genreTest')
                 ->setParutionDate($dateTimeTest)
                 ->setStatus(true)
                 ->addKeyWord($keyWordTest)
                 ->addCategory($categoryTest)
                 ->addFormat($formatTest)
                 ->setEditor($editorTest)
                 ->addBoSkCo($boSkCoTest)
                 ->addToBeReads($toBeReadTest);
        
        $bookTest->setCreatedAtValue();
        $bookTest->setUpdatedAtValue();

        $this->assertTrue($bookTest->getTitle() === 'Test de titre');
        $this->assertTrue($bookTest->getCover() === 'test-de-cover.jpg');
        $this->assertTrue($bookTest->getSummary() === 'Je teste le summary, résumé du livre');
        $this->assertTrue($bookTest->getGenre() === 'genreTest');
        $this->assertTrue($bookTest->getParutionDate() === $dateTimeTest);
        $this->assertNotNull($bookTest->getCreatedAt());
        $this->assertNotNull($bookTest->getUpdatedAt());
        $this->assertTrue($bookTest->isStatus() === true);
        $this->assertContains($keyWordTest, $bookTest->getKeyWords());
        $this->assertContains($categoryTest, $bookTest->getCategories());
        $this->assertContains($formatTest, $bookTest->getFormats());
        $this->assertTrue($bookTest->getEditor() === $editorTest);
        $this->assertContains($boSkCoTest, $bookTest->getBoSkCos());
        $this->assertContains($toBeReadTest, $bookTest->getToBeReads());
        $this->assertEquals($bookTest->getCreatedAt()->format('Y-m-d H:i:s'), $bookTest->getUpdatedAt()->format('Y-m-d H:i:s'));
    }

    public function testIsFalse(): void
    {
        $dateTimeTest = new DateTime();
        $toBeReadTest = new ToBeRead();
        $keyWordTest = new KeyWord();
        $categoryTest = new Category();
        $formatTest = new Format();
        $feedbackTest = new Feedback();
        $editorTest = new Editor();
        $boSkCoTest = new BoSkCo();
        $bookTest = new Book();
        $bookTest->setTitle('Test de titre')
                 ->setCover('test-de-cover.jpg')
                 ->setSummary('Je teste le summary, résumé du livre')
                 ->setGenre('genreTest')
                 ->setParutionDate($dateTimeTest)
                 ->setStatus(true)
                 ->addKeyWord($keyWordTest)
                 ->addCategory($categoryTest)
                 ->addFormat($formatTest)
                 ->setEditor($editorTest)
                 ->addBoSkCo($boSkCoTest)
                 ->addToBeReads($toBeReadTest);

        $this->assertFalse($bookTest->getTitle() === 'Test de titre faux');
        $this->assertFalse($bookTest->getCover() === 'test-de-cover-faux.jpg');
        $this->assertFalse($bookTest->getSummary() === 'Je teste le summary, faux résumé du livre');
        $this->assertFalse($bookTest->getGenre() === 'genreTestFaux');
        $this->assertFalse($bookTest->getParutionDate() === new DateTime());
        $this->assertFalse($bookTest->getCreatedAt() === new DateTime());
        $this->assertFalse($bookTest->getUpdatedAt() === new DateTime());
        $this->assertFalse($bookTest->isStatus() === false);
        $this->assertNotContains(new KeyWord(), $bookTest->getKeyWords());
        $this->assertNotContains(new Category(), $bookTest->getCategories());
        $this->assertNotContains(new Format(), $bookTest->getFormats());
        $this->assertFalse($bookTest->getEditor() === new Editor());
        $this->assertNotContains(new BoSkCo(), $bookTest->getBoSkCos());
        $this->assertNotContains(new ToBeRead(), $bookTest->getToBeReads());
    }

    public function testIsEmpty(): void
    {
        $bookTest = new Book();
        $this->assertEmpty($bookTest->getTitle());
        $this->assertEmpty($bookTest->getCover());
        $this->assertEmpty($bookTest->getSummary());
        $this->assertEmpty($bookTest->getGenre());
        $this->assertEmpty($bookTest->getParutionDate());
        $this->assertEmpty($bookTest->getCreatedAt());
        $this->assertEmpty($bookTest->getUpdatedAt());
        $this->assertEmpty($bookTest->isStatus());
        $this->assertEmpty($bookTest->getEditor());
    }

    public function testGetAverageStars(): void
    {
        $book = new Book();

        $format1 = new Format();
        $format2 = new Format();

        $feedback1 = new Feedback();
        $feedback1->setStars(4);

        $feedback2 = new Feedback();
        $feedback2->setStars(5);

        $feedback3 = new Feedback();
        $feedback3->setStars(3);

        $format1->addFeedback($feedback1);
        $format1->addFeedback($feedback2);
        $format2->addFeedback($feedback3);

        $book->addFormat($format1);
        $book->addFormat($format2);

        $this->assertEquals(4.0, $book->getAverageStars());
    }

    public function testGetAverageStarsReturnsZeroWhenNoFeedback(): void
    {
        $book = new Book();
        $format = new Format();

        $book->addFormat($format);

        $this->assertSame(0.0, $book->getAverageStars());
    }
}
