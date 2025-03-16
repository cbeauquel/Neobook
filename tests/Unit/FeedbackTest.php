<?php

namespace App\Tests;

use DateTime;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\Feedback;
use PHPUnit\Framework\TestCase;

class FeedbackTest extends TestCase
{
    public function testIsTrue(): void
    {
        $userTest = new User();
        $bookTest = new Book();
        $feedbackTest = new Feedback();
        $feedbackTest->setNickName($userTest)
                     ->setStars(2)
                     ->setComment('test de commentaire')
                     ->setBook($bookTest);
        $feedbackTest->setCreatedAtValue();
        $feedbackTest->setUpdatedAtValue();

        $this->assertTrue($feedbackTest->getNickName() === $userTest);
        $this->assertTrue($feedbackTest->getStars() === 2);
        $this->assertTrue($feedbackTest->getComment() === 'test de commentaire');
        $this->assertTrue($feedbackTest->getBook() === $bookTest);
        $this->assertEquals($feedbackTest->getCreatedAt()->format('Y-m-d H:i:s'), $feedbackTest->getUpdatedAt()->format('Y-m-d H:i:s'));
    }

    public function testIsFalse(): void
    {
        $userTest = new User();
        $bookTest = new Book();
        $feedbackTest = new Feedback();
        $feedbackTest->setNickName($userTest)
                     ->setStars('2')
                     ->setComment('test de commentaire')
                     ->setBook($bookTest);
        $feedbackTest->setCreatedAtValue();
        $feedbackTest->setUpdatedAtValue();

        $this->assertFalse($feedbackTest->getNickName() === new User());
        $this->assertFalse($feedbackTest->getStars() === '1');
        $this->assertFalse($feedbackTest->getComment() === 'test de commentaire faux');
        $this->assertFalse($feedbackTest->getBook() === new Book());
        $this->assertFalse($feedbackTest->getCreatedAt() === new DateTime());
        $this->assertFalse($feedbackTest->getUpdatedAt() === new DateTime());
    }

    
    public function testIsEmpty(): void
    {
        $feedbackTest = new Feedback();

        $this->assertEmpty($feedbackTest->getNickName());
        $this->assertEmpty($feedbackTest->getStars());
        $this->assertEmpty($feedbackTest->getComment());
        $this->assertEmpty($feedbackTest->getBook());
        $this->assertEmpty($feedbackTest->getCreatedAt());
        $this->assertEmpty($feedbackTest->getUpdatedAt());
    }

}
