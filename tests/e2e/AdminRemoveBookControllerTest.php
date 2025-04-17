<?php

declare(strict_types=1);

namespace App\Tests\e2e;

use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;

final class AdminRemoveBookControllerTest extends PantherTestCase
{
    public function testShouldRemoveBook(): void
    {
        // Navigate to the new book form page
        $client = self::createPantherClient([
            'browser' => PantherTestCase::CHROME,
            'external_base_uri' => 'http://localhost:8000',
            'chrome_options' => [
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--headless', // utile même si implicite
            ],
        ]);
        $crawler = $client->request('GET', '/admin/book');
        $client->waitFor('form.login', 10); // la page admin book

        $crawler->filter('input[name="_username"]')->sendKeys('c.beauquel@neobook.fr');
        $crawler->filter('input[name="_password"]')->sendKeys('trucmuche');
        $crawler->filter('form.login')->submit();

        $client->waitForElementToContain('h1', 'Liste des livres'); // la page admin book
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('body > section > table > tbody > tr:nth-child(1) > td:nth-child(7) > form > button'))->click();
        $client->getWebDriver()->switchTo()->alert()->accept();
        $crawler = $client->request('GET', '/admin/book/');
        $this->assertAnySelectorTextNotContains('td', 'Titre du livre modifié');
        $crawler = $client->request('GET', '/logout');
    }
}
