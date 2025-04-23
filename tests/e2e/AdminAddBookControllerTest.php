<?php

declare(strict_types=1);

namespace App\Tests\e2e;

use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverDimension;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;

final class AdminAddBookControllerTest extends PantherTestCase
{
    public function testShouldAddNewBook(): void
    {
        // Navigate to the new book form page
        $client = self::createPantherClient([
            'browser' => PantherTestCase::CHROME,
            'external_base_uri' => 'http://127.0.0.1:8000',
            // 'chrome_options' => [
            //     '--no-sandbox',
            //     '--disable-dev-shm-usage',
            //     '--headless', // utile même si implicite
            // ],
        ]);

        $client->getWebDriver()->manage()->window()->setSize(new WebDriverDimension(1920, 1080));
        $crawler = $client->request('GET', '/account');
        try {
            $client->waitFor('form.login', 2);
        } catch (\Throwable $e) {
            file_put_contents('/tmp/login-error.html', $client->getPageSource());
            throw $e;
        }
        $crawler->filter('input[name="_username"]')->sendKeys('c.beauquel@neobook.fr');
        $crawler->filter('input[name="_password"]')->sendKeys('trucmuche');
        $client->waitForElementToContain('form.login', 'Se connecter'); // la page admin book
        $crawler->filter('form.login')->submit();
        $client->waitForElementToContain('h1', 'Compte de Christophe');

        $client->request('GET', '/admin/book');
        $screenshotPath = sprintf(
            __DIR__ . '/../../build/artifacts/%s.png',
            (new \ReflectionClass($this))->getShortName()
        );
        $client->getWebDriver()->takeScreenshot($screenshotPath);
        sleep(2); // petite pause
        $client->getWebDriver()->takeScreenshot('/tmp/test.png');
        $this->assertSelectorTextSame('h1', 'Liste des livres');
        $client->waitForElementToContain('a.add', 'Ajouter un livre');

        $crawler = $client->request('GET', '/admin/book/add');

        $client->waitForElementToContain('h1', 'Ajouter un livre'); // la page admin book
        $photoPath = realpath(dirname(__DIR__, 2) . '/assets/img/livres/une-fleur-pour-l-eternite.jpg');

        $client->waitFor('#book_BoSkCos > button', 10); // ton bouton "Ajouter un contributeur"
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('#book_BoSkCos > button'))->click();

        // Fill contributor fields
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[BoSkCos][0][contributor]"]'))->sendKeys('3');
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[BoSkCos][0][skill]"]'))->sendKeys('4');

        // Fill editor fields
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[editor]"]'))->sendKeys('5');

        // Fill Category fields
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[categories][]"]'))->sendKeys('11');

        // Fill other required fields
        $crawler->filter('input[name="book[title]"]')->sendKeys('Nouveau titre de livre');
        $crawler->filter('input[name="book[cover]"]')->sendKeys($photoPath);
        $crawler->filter('textarea[name="book[summary]"]')->sendKeys('Description du nouveau livre qui a pour auteur Lyonel Shearer');
        $crawler->filter('input[name="book[genre]"]')->sendKeys('genre-du-nouveau-livre');
        $crawler->filter('input[name="book[parutionDate]"]')->sendKeys('01/01/2026');
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('input[name="book[status]"]'))->sendKeys('1');
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[keyWords][]"]'))->sendKeys('180');
        // Click the 'Add Format' button via Stimulus controller
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('#book_formats > button'))->click();
        $client->waitFor('div.book-formats', 2); // la page admin book

        // Fill the new dynamic fields
        $crawler->filter('input[name="book[formats][0][ISBN]"]')->sendKeys('9799999999999');
        $crawler->filter('input[name="book[formats][0][priceHT]"]')->sendKeys('9.99');
        $crawler->filter('input[name="book[formats][0][priceTTC]"]')->sendKeys('10.04');
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('input[name="book[formats][0][tvaRate]"][value="1"]'))->click();
        
        $crawler->filter('input[name="book[formats][0][duration]"]')->sendKeys('240');
        $crawler->filter('input[name="book[formats][0][wordsCount]"]')->sendKeys('9999');
        $crawler->filter('input[name="book[formats][0][pagesCount]"]')->sendKeys('300');
        $crawler->filter('input[name="book[formats][0][fileSize]"]')->sendKeys('2.5');
        $crawler->filter('input[name="book[formats][0][filePath]"]')->sendKeys('test.fr/test.epub');
        $crawler->filter('input[name="book[formats][0][bookExtract]"]')->sendKeys('test.fr/extract.epub');
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('input[name="book[formats][0][type]"][value="1"]'))->click();

        // Submit the form via native JS to ensure all bindings are respected
        $client->executeScript('document.querySelector("form[name=book]").submit()');

        // Wait for redirect or success message
        $crawler = $client->request('GET', '/admin/book');
        $this->assertAnySelectorTextContains('td', 'Nouveau titre de livre');
        $crawler = $client->request('GET', '/logout');
    }
}
