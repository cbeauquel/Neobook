<?php

declare(strict_types=1);

namespace App\Tests\Functional\Auth;

use App\Entity\User;
use App\Tests\Functional\FunctionalTestCase;
use Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegisterTest extends FunctionalTestCase
{
    public function testThatRegistrationShouldSucceeded(): void
    {
        $this->get('/register');

        $this->client->submitForm('Je crée mon compte', self::getFormData());

        // self::assertResponseRedirects('/');

        $user = $this->getEntityManager()->getRepository(User::class)->findOneByEmail('user@email.com');

        $userPasswordHasher = $this->service(UserPasswordHasherInterface::class);

        self::assertNotNull($user);
        self::assertSame('firstname', $user->getFirstname());
        self::assertSame('lastname', $user->getLastname());
        self::assertSame('nickName', $user->getNickName());
        self::assertSame('user@email.com', $user->getEmail());
        self::assertTrue($userPasswordHasher->isPasswordValid($user, 'SuperPassword123!'));
    }

    /**
     * @dataProvider provideInvalidFormData
     * @param array<string> $formData
     */
    public function testThatRegistrationShouldFailed(array $formData): void
    {
        $this->get('/register');
        $this->client->submitForm('Je crée mon compte', $formData);
        $this->assertResponseStatusCodeSame(422);
    }

    /**
     * @return array<int, list<array<string, string>>>
     */
    public static function provideInvalidFormData(): array
    {
        return [
            [['registration_form[firstname]' => '']],
            [['registration_form[lastname]' => 'user+1']],
            [['registration_form[nickName]' => 'Lorem ipsum dolor sit amet orci aliquam']],
            [['registration_form[email]' => '']],
            [['registration_form[email]' => 'user+1@email.com']],
            [['registration_form[email]' => 'fail']],
        ];
    }

    /**
     * @param string[] $overrideData
     * @return string[]
     */
    public static function getFormData(array $overrideData = []): array
    {
        return [
            'registration_form[firstname]' => 'firstname',
            'registration_form[lastname]' => 'lastname',
            'registration_form[nickName]' => 'nickName',
            'registration_form[optIn]' => '1',
            'registration_form[email]' => 'user@email.com',
            'registration_form[plainPassword]' => 'SuperPassword123!'
        ] + $overrideData;
    }
}
