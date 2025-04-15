<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class AdminContributorControllerTest extends FunctionalTestCase
{
    /**
    * @dataProvider contributorProvider
    */
    public function testShoulListContributors(string $firstname, string $lastname): void
    {
        $this->get('/admin/contributor');
        self::assertResponseRedirects('/login');

        $this->login();
        $this->get('/admin/contributor');
        $this->assertResponseStatusCodeSame(403, 'Access Denied');

        $this->loginAdmin();
        $this->get('/admin/contributor');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('H1', 'Liste des contributeurs');
        self::assertAnySelectorTextSame('td', $firstname);
        self::assertAnySelectorTextSame('td', $lastname);
    }

    /**
    * @return array<int, list<int|string>>
    */
    public function contributorProvider(): array
    {
        return [
            ['Lyonel', 'Shearer'],
            ['Françoise', 'Le Gloahec'],
            ['Jean-François', 'Vaissière'],
            ['Anne', 'Jovanovic'],
            ['Yves', 'Carchon'],
            ['Marcel', 'Grelet'],
            ['Bernard', 'Bessou'],
            ['Philippe', 'Grandcoin'],
            ['Christian', 'Laborie'],
        ];
    }

    public function testShouldAddContributor(): void
    {
        $photoPath = realpath(dirname(__DIR__, 2) . '/assets/img/livres/une-fleur-pour-l-eternite.jpg');
        $uploadedFile = new UploadedFile(
            $photoPath,
            'une-fleur-pour-l-eternite.jpg',
            'image/jpeg',
            null,
            true // true pour "test mode" : fichier réel déjà présent, pas déplacé
        );

        $this->loginAdmin();
        $this->get('/admin/contributor');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Liste des contributeurs');
        $this->client->clickLink('Ajouter un contributeur');
        $this->get('/admin/contributor/add');
        $this->assertSelectorTextSame('h1', 'Ajouter un contributeur');
        $this->client->followRedirects();
        $this->client->submitForm(
            'Envoyer',
            [
            'contributor[lastname]' => 'NewContributorLastName',
            'contributor[firstname]' => 'NewContributorFirstname',
            'contributor[bio]' => 'Ceci est une bio de test qui doit faire 10 mots minimum',
            'contributor[photo]' => $uploadedFile,
            'contributor[status]' => '1',
            'contributor[slug]' => 'slugtest'
            ]
        );
        $this->assertResponseIsSuccessful();
        self::assertAnySelectorTextSame('td', 'NewContributorLastName');
    }

    public function testShouldEditContributor(): void
    {
        $contributorId = $this->getLastContributorId();
        $this->loginAdmin();
        $this->get('/admin/contributor');
        $this->assertResponseIsSuccessful();
        $this->client->clickLink('Modifier ' . $contributorId);
        $this->client->followRedirects();
        $this->client->submitForm(
            'Envoyer',
            [
            'contributor[lastname]' => 'ModifiedLastName',
            'contributor[firstname]' => 'ModifiedFirstname',
            ]
        );
        $this->assertResponseIsSuccessful();
        self::assertAnySelectorTextSame('td', 'ModifiedLastName');
    }
    
    public function testShouldRemoveContributor(): void
    {
        $contributorId = $this->getLastContributorId();
        $this->loginAdmin();
        $this->get('/admin/contributor');
        $this->assertResponseIsSuccessful();
        $this->client->submitForm($contributorId);
        $this->client->followRedirects();
        $this->get('/admin/contributor');
        self::assertAnySelectorTextNotContains('td', 'ModifiedLastName');
    }
}
