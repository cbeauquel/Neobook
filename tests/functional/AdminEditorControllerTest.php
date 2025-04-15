<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class AdminEditorControllerTest extends FunctionalTestCase
{
    /**
    * @dataProvider editorProvider
    */
    public function testShoulListEditors(string $name): void
    {
        $this->get('/admin/editor');
        self::assertResponseRedirects('/login');

        $this->login();
        $this->get('/admin/editor');
        $this->assertResponseStatusCodeSame(403, 'Access Denied');

        $this->loginAdmin();
        $this->get('/admin/editor');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('H1', 'Liste des éditeurs');
        self::assertAnySelectorTextSame('td', $name);
    }

    /**
    * @return array<int, list<int|string>>
    */
    public function editorProvider(): array
    {
        return [
            ['De Borée'],
            ['Amphora'],
            ['Cairn'],
            ['Ella'],
            ['Marivole'],
        ];
    }

    public function testShouldAddEditor(): void
    {
        $photoPath = realpath(dirname(__DIR__, 2) . '/assets/img/editeurs/amphora.jpg');
        $uploadedFile = new UploadedFile(
            $photoPath,
            'amphora.jpg',
            'image/jpeg',
            null,
            true // true pour "test mode" : fichier réel déjà présent, pas déplacé
        );

        $this->loginAdmin();
        $this->get('/admin/editor');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Liste des éditeurs');
        $this->client->clickLink('Ajouter un éditeur');
        $this->get('/admin/editor/add');
        $this->assertSelectorTextSame('h1', 'Ajouter un éditeur');
        $this->client->followRedirects();
        $this->client->submitForm(
            'Envoyer',
            [
            'editor[name]' => 'NewEditorName',
            'editor[description]' => 'Ceci est une description de test qui doit faire 10 mots minimum',
            'editor[logo]' => $uploadedFile,
            'editor[status]' => '1',
            ]
        );
        $this->assertResponseIsSuccessful();
        self::assertAnySelectorTextSame('td', 'NewEditorName');
    }

    public function testShouldEditEditor(): void
    {
        $editorId = $this->getLastEditorId();
        $this->loginAdmin();
        $this->get('/admin/editor');
        $this->assertResponseIsSuccessful();
        $this->client->clickLink('Modifier ' . $editorId);
        $this->client->followRedirects();
        $this->client->submitForm(
            'Envoyer',
            [
            'editor[name]' => 'ModifiedEditorName',
            ]
        );
        $this->assertResponseIsSuccessful();
        self::assertAnySelectorTextSame('td', 'ModifiedEditorName');
    }
    
    public function testShouldRemoveEditor(): void
    {
        $editorId = $this->getLastEditorId();
        $this->loginAdmin();
        $this->get('/admin/editor');
        $this->assertResponseIsSuccessful();
        $this->client->submitForm($editorId);
        $this->client->followRedirects();
        $this->get('/admin/editor');
        self::assertAnySelectorTextNotContains('td', 'ModifiedEditorName');
    }
}
