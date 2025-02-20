<?php

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TypeFixtures extends Fixture
{

    public function load (ObjectManager $manager):void
    {
        $formatTypes = ['Audio', 'eBook'];
        $imgTypes = ['Audio', 'eBook'];

        foreach ($formatTypes as $key => $type) {
            $newType = new Type();
            $newType->setName($type);
            $newType->setTypeImg($imgTypes[$key]); // Associer l'image correspondante

            $manager->persist($newType);
        }        
        
        $manager->flush();
    }
}