<?php

namespace App\Tests\Unit;

use App\Entity\Feedback;
use App\Entity\Format;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class FeedbackTest extends TestCase
{
    public function testIsTrue(): void
    {
        $userTest = new User();
        $formatTest = new Format();
        $feedbackTest = new Feedback();
        $feedbackTest->setNickName($userTest)
                     ->setStars(2)
                     ->setComment('test de commentaire')
                     ->setFormat($formatTest);
        $feedbackTest->setCreatedAtValue();
        $feedbackTest->setUpdatedAtValue();

        $this->assertTrue($feedbackTest->getNickName() === $userTest);
        $this->assertTrue($feedbackTest->getStars() === 2);
        $this->assertTrue($feedbackTest->getComment() === 'test de commentaire');
        $this->assertTrue($feedbackTest->getFormat() === $formatTest);
        $this->assertEquals($feedbackTest->getCreatedAt()->format('Y-m-d H:i:s'), $feedbackTest->getUpdatedAt()->format('Y-m-d H:i:s'));
    }

    public function testIsFalse(): void
    {
        $userTest = new User();
        $formatTest = new Format();
        $feedbackTest = new Feedback();
        $feedbackTest->setNickName($userTest)
                     ->setStars(2)
                     ->setComment('test de commentaire')
                     ->setFormat($formatTest);
        $feedbackTest->setCreatedAtValue();
        $feedbackTest->setUpdatedAtValue();

        $this->assertFalse($feedbackTest->getNickName() === new User());
        $this->assertFalse($feedbackTest->getStars() === 1);
        $this->assertFalse($feedbackTest->getComment() === 'test de commentaire faux');
        $this->assertFalse($feedbackTest->getFormat() === new Format());
        $this->assertFalse($feedbackTest->getCreatedAt() === new DateTime());
        $this->assertFalse($feedbackTest->getUpdatedAt() === new DateTime());
    }
    
    public function testIsEmpty(): void
    {
        $feedbackTest = new Feedback();

        $this->assertEmpty($feedbackTest->getNickName());
        $this->assertEmpty($feedbackTest->getStars());
        $this->assertEmpty($feedbackTest->getComment());
        $this->assertEmpty($feedbackTest->getFormat());
        $this->assertEmpty($feedbackTest->getCreatedAt());
        $this->assertEmpty($feedbackTest->getUpdatedAt());
    }
}
