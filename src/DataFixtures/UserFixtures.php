<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher){}

    public function load (ObjectManager $manager):void
    {
        $newUser = new User();
        $newUser->setFirstname('Christophe');
        $newUser->setLastname('Beauquel');
        $newUser->setNickname('cbeauquel');
        $newUser->setEmail('c.beauquel@neobook.fr');
        $newUser->setRoles(['ROLE_ADMIN']);
        $newUser->setPassword($this->hasher->hashPassword($newUser, 'trucmuche'));
        $newUser->setOptin('1');
        $newUser->setVerified('1');

        $manager->persist($newUser);
        $manager->flush();
    }
}