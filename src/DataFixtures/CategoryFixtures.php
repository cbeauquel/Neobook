<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CategoryFixtures extends Fixture
{
    public function load (ObjectManager $manager):void
    {
       $categories = ['Classiques', 'Roman noir', 'Romance', 'Fantasy, SF', 'Roman historique', 'Théâtre', 'Contes et nouvelles', 'Poésie', 'Jeunesse', 'Essais, témoignage', 'Biographies', 'Sport et bien-être'];
       foreach($categories as $category){
       $newCategory = new Category();
       $newCategory->setName($category);
    }

    $manager->persist($newCategory);
    $manager->flush();

    }
}