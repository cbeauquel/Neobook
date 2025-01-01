<?php

namespace App\DataFixtures;

use App\Factory\BookFactory;
use App\Factory\AuthorFactory;
use App\Factory\EditorFactory;
use App\Factory\FormatFactory;
use App\Factory\CategoryFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AuthorFactory::createMany(6);
        EditorFactory::createMany(4);
        FormatFactory::createMany(2);
        CategoryFactory::createMany(12);
        BookFactory::createMany(12);

        $manager->flush();
    }
}
