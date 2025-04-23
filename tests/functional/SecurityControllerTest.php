<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class SecurityControllerTest extends FunctionalTestCase
{
    public function testThatLoginShouldSucceeded(): void
    {
        $this->get('/login');

        $this->client->submitForm('Se connecter', [
            '_username' => 'beauquelc@yahoo.fr',
            '_password' => 'trucmuche'
        ]);

        $authorizationChecker = $this->service(AuthorizationCheckerInterface::class);

        self::assertTrue($authorizationChecker->isGranted('IS_AUTHENTICATED'));

        $this->get('/logout');

        self::assertFalse($authorizationChecker->isGranted('IS_AUTHENTICATED'));
    }

    public function testThatLoginShouldFailed(): void
    {
        $this->get('/login');

        $this->client->submitForm('Se connecter', [
            '_username' => 'beauquelc@yahoo.fr',
            '_password' => 'fail'
        ]);

        $authorizationChecker = $this->service(AuthorizationCheckerInterface::class);

        self::assertFalse($authorizationChecker->isGranted('IS_AUTHENTICATED'));
    }
}
