<?php

declare(strict_types=1);

namespace App\Tests\e2e;

use Facebook\WebDriver\WebDriverBy;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;

final class AdminEditBookControllerTest extends PantherTestCase
{
    public function testShouldEditBook(): void
    {
        // Navigate to the new book form page
        $client = self::createPantherClient([
            'browser' => PantherTestCase::CHROME
        ]);
        $crawler = $client->request('GET', '/admin/book');
        $client->waitFor('form.login', 2); // la page admin book

        $crawler->filter('input[name="_username"]')->sendKeys('c.beauquel@neobook.fr');
        $crawler->filter('input[name="_password"]')->sendKeys('trucmuche');
        $crawler->filter('form.login')->submit();

        $client->waitForElementToContain('h1', 'Liste des livres'); // la page admin book
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('body > section > table > tbody > tr:nth-child(1) > td:nth-child(7) > a.btn.btn-warning.btn-sm'))->click();
        $client->waitForElementToContain('h1', 'Ajouter un livre'); // la page admin book
        $this->assertSelectorTextSame('h1', 'Ajouter un livre');

        // // Fill contributor fields
        // $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[BoSkCos][0][contributor]"]'))->sendKeys('3');
        // $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[BoSkCos][0][skill]"]'))->sendKeys('4');

        // // Fill editor fields
        // $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[editor]"]'))->sendKeys('5');

        // // Fill Category fields
        // $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[categories][]"]'))->sendKeys('11');

        // // Fill other required fields
        $client->getWebDriver()->findElement(WebDriverBy::cssSelector('input[name="book[title]"]'))->clear()->sendKeys('Titre du livre modifié');
        // $crawler->filter('input[name="book[cover]"]')->sendKeys('C:\Users\user\OneDrive\Documents\Openclassrooms\Projet_13_15\Neobook\assets\img\livres\les-illusions-orientales.jpg');
        // $crawler->filter('textarea[name="book[summary]"]')->sendKeys('Description du nouveau livre qui a pour auteur Lyonel Shearer');
        // $crawler->filter('input[name="book[genre]"]')->sendKeys('genre-du-nouveau-livre');
        // $crawler->filter('input[name="book[parutionDate]"]')->sendKeys('01/01/2026');
        // $client->getWebDriver()->findElement(WebDriverBy::cssSelector('input[name="book[status]"]'))->sendKeys('1');
        // $client->getWebDriver()->findElement(WebDriverBy::cssSelector('select[name="book[keyWords][]'))->sendKeys('180');
        
        // // Click the 'Add Format' button via Stimulus controller
        // $client->getWebDriver()->findElement(WebDriverBy::cssSelector('#book_formats > button'))->click();
        // $client->waitFor('div.book-formats', 2); // la page admin book

        // // Fill the new dynamic fields
        // $crawler->filter('input[name="book[formats][0][ISBN]"]')->sendKeys('9799999999999');
        // $crawler->filter('input[name="book[formats][0][priceHT]"]')->sendKeys('9.99');
        // $crawler->filter('input[name="book[formats][0][priceTTC]"]')->sendKeys('10.04');
        // $client->getWebDriver()->findElement(WebDriverBy::cssSelector('input[name="book[formats][0][tvaRate]"][value="1"]'))->click();
        
        // $crawler->filter('input[name="book[formats][0][duration]')->sendKeys('240');
        // $crawler->filter('input[name="book[formats][0][wordsCount]')->sendKeys('9999');
        // $crawler->filter('input[name="book[formats][0][pagesCount]')->sendKeys('300');
        // $crawler->filter('input[name="book[formats][0][fileSize]')->sendKeys('2.5');
        // $crawler->filter('input[name="book[formats][0][filePath]')->sendKeys('test.fr/test.epub');
        // $crawler->filter('input[name="book[formats][0][bookExtract]')->sendKeys('test.fr/extract.epub');
        // $client->getWebDriver()->findElement(WebDriverBy::cssSelector('input[name="book[formats][0][type]"][value="1"]'))->click();

        // Submit the form
        // Submit the form via native JS to ensure all bindings are respected
        $client->executeScript('document.querySelector("form[name=book]").submit()');
        // Wait for redirect or success message
        $crawler = $client->request('GET', '/admin/book/');
        $this->assertAnySelectorTextContains('td', 'Titre du livre modifié');
        $crawler = $client->request('GET', '/logout');
    }
}
