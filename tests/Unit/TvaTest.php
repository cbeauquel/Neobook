<?php

namespace App\Tests;

use App\Entity\Tva;
use App\Entity\Format;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class TvaTest extends TestCase
{
    public function testIsTrue(): void
    {
        $formatTest = new Format();
        $formatsTest = new ArrayCollection($elements = [$formatTest]);

        $tvaTest = new Tva();
        $tvaTest->setTaux(5.5)
                ->addFormat($formatTest)
                ->setFormatTvaRate($formatsTest);

        $this->assertTrue($tvaTest->getTaux() === 5.5);
        $this->assertTrue($tvaTest->getFormatTvaRate() === $formatsTest);
    }

    public function testIsFalse(): void
    {
        $formatTest = new Format();
        $formatsTest = new ArrayCollection($elements = [$formatTest]);

        $tvaTest = new Tva();
        $tvaTest->setTaux(5.5)
                ->addFormat($formatTest)
                ->setFormatTvaRate($formatsTest);

        $this->assertFalse($tvaTest->getTaux() === 20);
        $this->assertFalse($tvaTest->getFormatTvaRate() === new ArrayCollection($elements = [$formatTest]));
    }

    public function testIsEmpty(): void
    {
        $tvaTest = new Tva();
        $this->assertEmpty($tvaTest->getTaux());
        $this->assertEmpty($tvaTest->getFormatTvaRate());
    }
}
