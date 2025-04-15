<?php

namespace App\Tests\Unit;

use App\Entity\BoSkCo;
use App\Entity\Contributor;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class ContributorTest extends TestCase
{
    public function testIsTrue(): void
    {
        $boSkCoTest = new BoSkCo();
        $boSkCoTests = new ArrayCollection($elements = [$boSkCoTest]);
        $contributorTest = new Contributor();
        $contributorTest->setFirstname('firstnameTest')
                        ->setLastname('lastnameTest')
                        ->setBio('bioTest')
                        ->setPhoto('phototest.jpg')
                        ->setStatus(true)
                        ->setSlug('firstnameLastnameTest')
                        ->setBoSkCos($boSkCoTests);

        $this->assertTrue($contributorTest->getFirstname() === 'firstnameTest');
        $this->assertTrue($contributorTest->getLastname() === 'lastnameTest');
        $this->assertTrue($contributorTest->getBio() === 'bioTest');
        $this->assertTrue($contributorTest->getPhoto() === 'phototest.jpg');
        $this->assertTrue($contributorTest->isStatus() === true);
        $this->assertTrue($contributorTest->getSlug() === 'firstnameLastnameTest');
        $this->assertTrue($contributorTest->getBoSkCos() === $boSkCoTests);
    }

    public function testIsFalse(): void
    {
        $boSkCoTest = new BoSkCo();
        $boSkCoTests = new ArrayCollection($elements = [$boSkCoTest]);
        $contributorTest = new Contributor();
        $contributorTest->setFirstname('firstnameTest')
                        ->setLastname('lastnameTest')
                        ->setBio('bioTest')
                        ->setPhoto('phototest.jpg')
                        ->setStatus(true)
                        ->setSlug('firstnameLastnameTest')
                        ->setBoSkCos($boSkCoTests);

        $this->assertFalse($contributorTest->getFirstname() === 'firstnameTestFalse');
        $this->assertFalse($contributorTest->getLastname() === 'lastnameTestFalse');
        $this->assertFalse($contributorTest->getBio() === 'bioTestFalse');
        $this->assertFalse($contributorTest->getPhoto() === 'phototestFalse.jpg');
        $this->assertFalse($contributorTest->isStatus() === false);
        $this->assertFalse($contributorTest->getSlug() === 'firstnameLastnameTestFalse');
        $this->assertFalse($contributorTest->getBoSkCos() === new ArrayCollection($elements = [$boSkCoTest]));
    }

    public function testIsEmpty(): void
    {
        $contributorTest = new Contributor();
        $this->assertEmpty($contributorTest->getFirstname());
        $this->assertEmpty($contributorTest->getLastname());
        $this->assertEmpty($contributorTest->getBio());
        $this->assertEmpty($contributorTest->getPhoto());
        $this->assertEmpty($contributorTest->isStatus());
        $this->assertEmpty($contributorTest->getSlug());
    }

    public function testRemoveBoSkCo(): void
    {
        $boSkCoTest = new BoSkCo();
        $contributorTest = new Contributor();

        $contributorTest->addBoSkCo($boSkCoTest); // gère aussi le setContributor() normalement
        $this->assertCount(1, $contributorTest->getBoSkCos());
    
        $contributorTest->removeBoSkCo($boSkCoTest);
    
        $this->assertCount(0, $contributorTest->getBoSkCos());
        $this->assertNull($boSkCoTest->getContributor());
    }
}
