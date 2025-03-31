<?php

namespace App\Tests\Unit;

use App\Entity\Book;
use App\Entity\BoSkCo;
use App\Entity\Contributor;
use App\Entity\Skill;
use PHPUnit\Framework\TestCase;

class BoSkCoTest extends TestCase
{
    public function testIsTrue(): void
    {
        $skillTest = new Skill();
        $contributorTest = new Contributor();
        $bookTest = new Book();
        $boSkCoTest = new BoSkCo();
        $boSkCoTest->setContributor($contributorTest)
                   ->setSkill($skillTest)
                   ->setBook($bookTest);

        $this->assertTrue($boSkCoTest->getContributor() === $contributorTest);
        $this->assertTrue($boSkCoTest->getSkill() === $skillTest);
        $this->assertTrue($boSkCoTest->getBook() === $bookTest);
    }

    public function testIsFalse(): void
    {
        $skillTest = new Skill();
        $contributorTest = new Contributor();
        $bookTest = new Book();
        $boSkCoTest = new BoSkCo();
        $boSkCoTest->setContributor($contributorTest)
                   ->setSkill($skillTest)
                   ->setBook($bookTest);

        $this->assertFalse($boSkCoTest->getContributor() === new Contributor());
        $this->assertFalse($boSkCoTest->getSkill() === new Skill());
        $this->assertFalse($boSkCoTest->getBook() === new Book());
    }

    public function testIsEmpty(): void
    {
        $boSkCoTest = new BoSkCo();
        $this->assertEmpty($boSkCoTest->getContributor());
        $this->assertEmpty($boSkCoTest->getSkill());
        $this->assertEmpty($boSkCoTest->getBook());
    }
}
