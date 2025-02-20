<?php

namespace App\DataFixtures;

use App\Entity\Tva;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TvaFixtures extends Fixture
{

    public function load (ObjectManager $manager):void
    {
        $TvaRate = ['5.5', '20'];
        foreach($TvaRate as $tvaTaux){
            $newTva = new Tva();
            $newTva->setTaux($tvaTaux);
        }

        $manager->persist($newTva);
        $manager->flush();
    }
}