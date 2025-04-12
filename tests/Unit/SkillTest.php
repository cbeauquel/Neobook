<?php

namespace App\Tests\Unit;

use App\Entity\BoSkCo;
use App\Entity\Skill;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class SkillTest extends TestCase
{
    public function testIsTrue(): void
    {
        $boSkCoTest = new BoSkCo();
        $boSkCosTest = new ArrayCollection($elements = [$boSkCoTest]);

        $skillTest = new Skill();
        $skillTest->setName('Auteur')
                  ->setBoSkCos($boSkCosTest);

        $this->assertTrue($skillTest->getName() === 'Auteur');
        $this->assertTrue($skillTest->getBoSkCos() === $boSkCosTest);
    }

    public function testIsFalse(): void
    {
        $boSkCoTest = new BoSkCo();
        $boSkCosTest = new ArrayCollection($elements = [$boSkCoTest]);

        $skillTest = new Skill();
        $skillTest->setName('Auteur')
                  ->setBoSkCos($boSkCosTest);

        $this->assertFalse($skillTest->getName() === 'Lecteur');
        $this->assertFalse($skillTest->getBoSkCos() === new ArrayCollection($elements = [$boSkCoTest]));
    }

    public function testIsEmpty(): void
    {
        $skillTest = new Skill();
        $this->assertEmpty($skillTest->getName());
    }
}
