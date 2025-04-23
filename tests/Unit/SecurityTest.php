<?php

namespace App\tests\Unit;

use App\Entity\User;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Model\VerifyEmailSignatureComponents;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class SecurityTest extends TestCase
{
    public function testSendEmailConfirmation(): void
    {
        // Arrange
        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('getId')
            ->willReturn(42);
        $user->expects($this->once())
            ->method('getEmail')
            ->willReturn('test@example.com');

        $signatureComponents = new VerifyEmailSignatureComponents(
            new \DateTimeImmutable('+1 hour'),
            'https://signed-url',
            time()
        );

        $verifyHelper = $this->createMock(VerifyEmailHelperInterface::class);
        $verifyHelper->expects($this->once())
            ->method('generateSignature')
            ->with('verify_route', '42', 'test@example.com')
            ->willReturn($signatureComponents);

        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function (TemplatedEmail $email) use ($signatureComponents) {
                $context = $email->getContext();
                $this->assertArrayHasKey('signedUrl', $context);
                $this->assertSame($signatureComponents->getSignedUrl(), $context['signedUrl']);
                $this->assertArrayHasKey('expiresAtMessageKey', $context);
                $this->assertArrayHasKey('expiresAtMessageData', $context);
                return true;
            }));

        $entityManager = $this->createMock(EntityManagerInterface::class);
        /** @var VerifyEmailHelperInterface $verifyHelper */ // Déclaration du type correct
        /** @var MailerInterface $mailer */ // Déclaration du type correct
        /** @var EntityManagerInterface $entityManager */ // Déclaration du type correct
        $emailVerifier = new EmailVerifier($verifyHelper, $mailer, $entityManager);// @phpstan-ignore varTag.nativeType, varTag.nativeType, varTag.nativeType

        $email = new TemplatedEmail();

        /** @var User $user */ // Déclaration du type correct
        // Act
        $emailVerifier->sendEmailConfirmation('verify_route', $user, $email); // @phpstan-ignore varTag.nativeType

        // Assert
        // Les assertions sont faites dans le callback du mock du mailer
    }
}
