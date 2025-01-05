<?php

namespace App\DataFixtures;

use App\Factory\BookFactory;
use App\Factory\SkillFactory;
use App\Factory\EditorFactory;
use App\Factory\FormatFactory;
use App\Factory\CategoryFactory;
use App\Factory\ContributorFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        SkillFactory::createMany(10);
        ContributorFactory::createMany(6);
        EditorFactory::createMany(4);
        FormatFactory::createMany(20);
        CategoryFactory::createMany(12);
        BookFactory::createMany(12);
        $manager->flush();
    }
}
