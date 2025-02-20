<?php

namespace App\DataFixtures;

use App\Factory\BookFactory;
use App\Factory\BoSkCoFactory;
use App\Factory\SkillFactory;
use App\Factory\EditorFactory;
use App\Factory\FormatFactory;
use App\Factory\CategoryFactory;
use App\Factory\ContributorFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Factory\TypeFactory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SkillFactory::createMany(3);
        ContributorFactory::createMany(6);
        EditorFactory::createMany(4);
        FormatFactory::createMany(22);
        BookFactory::createMany(12);
        BoSkCoFactory::createMany(24);
        $manager->flush();
    }
}
