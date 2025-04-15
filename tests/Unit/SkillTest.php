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
                  ->setBoSkCos($boSkCosTest)
                  ->addBoSkCo($boSkCoTest);

        $this->assertTrue($skillTest->getName() === 'Auteur');
        $this->assertTrue($skillTest->getBoSkCos() === $boSkCosTest);
    }

    public function testIsFalse(): void
    {
        $boSkCoTest = new BoSkCo();
        $boSkCosTest = new ArrayCollection($elements = [$boSkCoTest]);

        $skillTest = new Skill();
        $skillTest->setName('Auteur')
                  ->setBoSkCos($boSkCosTest)
                  ->addBoSkCo($boSkCoTest);


        $this->assertFalse($skillTest->getName() === 'Lecteur');
        $this->assertFalse($skillTest->getBoSkCos() === new ArrayCollection($elements = [$boSkCoTest]));
    }

    public function testIsEmpty(): void
    {
        $skillTest = new Skill();
        $this->assertEmpty($skillTest->getName());
    }

    public function testRemoveBoSkCo(): void
    {
        $boSkCoTest = new BoSkCo();
        $skillTest = new Skill();

        $skillTest->addBoSkCo($boSkCoTest); // gère aussi le setSkill() normalement
        $this->assertCount(1, $skillTest->getBoSkCos());
    
        $skillTest->removeBoSkCo($boSkCoTest);
    
        $this->assertCount(0, $skillTest->getBoSkCos());
        $this->assertNull($boSkCoTest->getSkill());
    }
}
