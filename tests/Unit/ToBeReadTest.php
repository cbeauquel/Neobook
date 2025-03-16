<?php

namespace App\Tests;

use App\Entity\Book;
use App\Entity\ToBeRead;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ToBeReadTest extends TestCase
{
    public function testIsTrue(): void
    {
        $userTest = new User();
        $bookTest = new Book();
        $toBeReadTest = new ToBeRead();
        $toBeReadTest->setCustomer($userTest)
                     ->setBook($bookTest)
                     ->setStatus('à lire');

        $this->assertTrue($toBeReadTest->getCustomer() === $userTest);
        $this->assertTrue($toBeReadTest->getBook() === $bookTest);
        $this->assertTrue($toBeReadTest->getStatus() === 'à lire');
    }

    public function testIsFalse(): void
    {
        $userTest = new User();
        $bookTest = new Book();
        $toBeReadTest = new ToBeRead();
        $toBeReadTest->setCustomer($userTest)
                     ->setBook($bookTest)
                     ->setStatus('à lire');

        $this->assertFalse($toBeReadTest->getCustomer() === new User());
        $this->assertFalse($toBeReadTest->getBook() === new Book());
        $this->assertFalse($toBeReadTest->getStatus() === 'lu');
    }
    
    public function testIsEmpty(): void
    {
        $toBeReadTest = new ToBeRead();

        $this->assertEmpty($toBeReadTest->getCustomer());
        $this->assertEmpty($toBeReadTest->getBook());
        $this->assertEmpty($toBeReadTest->getStatus());
    }
}
