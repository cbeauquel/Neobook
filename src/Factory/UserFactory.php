<?php

namespace App\Factory;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    public static function createCustomUsers(): void
    {
        self::createSequence([
            [
                'firstname' => 'Christophe',
                'lastname' => 'Beauquel',
                'nickname' => 'cbeauquel',
                'email' => 'c.beauquel@neobook.fr',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'trucmuche',
            ],
            [
                'firstname' => 'John',
                'lastname' => 'Smith',
                'nickname' => 'MR.Smith',
                'email' => 'beauquelc@yahoo.fr',
                'roles' => ['ROLE_USER'],
                'password' => 'trucmuche',
            ]
        ]);
    }

    public static function class(): string
    {
        return User::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     * @return array<mixed>
     */
    protected function defaults(): array
    {
        return [
            'nickname' => self::faker()->name(),
            'email' => self::faker()->email(),
            'roles' => [],
            'password' => self::faker()->password(),
            'optin' => self::faker()->boolean(),
            'verified' => self::faker()->boolean($chanceOfGettingTrue = 100),
            'lastVisitDate' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (User $user): void {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            })
        ;
    }
}
