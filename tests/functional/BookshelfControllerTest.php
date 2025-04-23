<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class BookshelfControllerTest extends FunctionalTestCase
{
    public function testShouldShowMyBooks(): void
    {
        $this->login();
        $user = $this->getCurrentUser();
        $this->get('/account');
        self::assertSelectorTextSame('h1', 'Compte de John');
        $this->client->clickLink('Gérer');
        $this->get('/bookshelf');
        $nbOfOrders = $this->countFormatsOnBookShelf($user);
        ///test d'affichage du nb de livres dans la bibliothèque
        self::assertSelectorCount($nbOfOrders, 'article.book-card-landscape');
        $formatsId = $this->getFormatsOfCustomerOrder($user);
        $nbOfFeedbacks = $this->countCustomerFeedbacks($user, $formatsId);
        self::assertSelectorCount($nbOfFeedbacks, 'ul.feedback');
    }
}
