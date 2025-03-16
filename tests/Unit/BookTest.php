<?php

namespace App\Tests;

use DateTime;
use App\Entity\Book;
use App\Entity\BoSkCo;
use App\Entity\Editor;
use App\Entity\Format;
use App\Entity\KeyWord;
use App\Entity\Category;
use App\Entity\Feedback;
use App\Entity\ToBeRead;
use PHPUnit\Framework\TestCase;
use App\Entity\Traits\TimestampableTrait;

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
                 ->setStatus('1')
                 ->addKeyWord($keyWordTest)
                 ->addCategory($categoryTest)
                 ->addFormat($formatTest)
                 ->addFeedback($feedbackTest)
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
        $this->assertContains($feedbackTest, $bookTest->getFeedbacks());
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
                 ->setStatus('1')
                 ->addKeyWord($keyWordTest)
                 ->addCategory($categoryTest)
                 ->addFormat($formatTest)
                 ->addFeedback($feedbackTest)
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
        $this->assertFalse($bookTest->isStatus() === '0');
        $this->assertNotContains(new KeyWord, $bookTest->getKeyWords());
        $this->assertNotContains(new Category, $bookTest->getCategories());
        $this->assertNotContains(new Format, $bookTest->getFormats());
        $this->assertNotContains(new Feedback, $bookTest->getFeedbacks());
        $this->assertFalse($bookTest->getEditor() === new Editor);
        $this->assertNotContains(new BoSkCo, $bookTest->getBoSkCos());
        $this->assertNotContains(new ToBeRead, $bookTest->getToBeReads());
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
        $this->assertEmpty($bookTest->getKeyWords());
        $this->assertEmpty($bookTest->getCategories());
        $this->assertEmpty($bookTest->getFormats());
        $this->assertEmpty($bookTest->getFeedbacks());
        $this->assertEmpty($bookTest->getEditor());
        $this->assertEmpty($bookTest->getBoSkCos());
        $this->assertEmpty($bookTest->getToBeReads());
    }


}
