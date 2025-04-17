<?php

namespace App\Tests\Unit;

use App\Entity\Format;
use App\Entity\Type;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class TypeTest extends TestCase
{
    public function testIsTrue(): void
    {
        $formatTest = new Format();
        $formatsTest = new ArrayCollection($elements = [$formatTest]);

        $typeTest = new Type();
        $typeTest->setTypeImg('book')
                 ->setName('ebook')
                 ->addFormatType($formatTest)
                 ->setFormatType($formatsTest);

        $this->assertTrue($typeTest->getTypeImg() === 'book');
        $this->assertTrue($typeTest->getName() === 'ebook');
        $this->assertTrue($typeTest->getFormatType() === $formatsTest);
    }

    public function testIsFalse(): void
    {
        $formatTest = new Format();
        $formatsTest = new ArrayCollection($elements = [$formatTest]);

        $typeTest = new Type();
        $typeTest->setTypeImg('book')
                 ->setName('ebook')
                 ->addFormatType($formatTest)
                 ->setFormatType($formatsTest);

        $this->assertFalse($typeTest->getTypeImg() === 'headphones');
        $this->assertFalse($typeTest->getName() === 'audio');
        $this->assertFalse($typeTest->getFormatType() === new ArrayCollection($elements = [$formatTest]));
    }

    public function testIsEmpty(): void
    {
        $typeTest = new Type();
        $this->assertEmpty($typeTest->getTypeImg());
        $this->assertEmpty($typeTest->getName());
    }

    public function testRemoveFormat(): void
    {
        $formatTest = new Format();
        $typeTest = new Type();

        $typeTest->addFormatType($formatTest); // gère aussi le setType() normalement
        $this->assertCount(1, $typeTest->getFormatType());
    
        $typeTest->removeFormatType($formatTest);
    
        $this->assertCount(0, $typeTest->getFormatType());
    }
}
