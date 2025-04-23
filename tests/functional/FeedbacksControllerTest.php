<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;

final class FeedbacksControllerTest extends FunctionalTestCase
{
    public function testShowFeedbacks(): void
    {
        $this->get('/account');
        self::assertResponseRedirects('/login');
        $this->login();
        $user = $this->getCurrentUser();
        $this->get('/account');
        $this->client->clickLink('Vos commentaires');
        $this->get('/myFeedbacks');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextSame('H1', 'Commentaires de John');
        $feedbacksByUser = $this->countFeedbacksByUser($user);
        self::assertSelectorCount($feedbacksByUser, 'tbody > tr');
    }

    public function testEditFeedbacks(): void
    {
        $this->login();
        $this->get('/myFeedbacks');
        self::assertSelectorTextSame('H2', 'Mes commentaires et évaluations');
        $user = $this->getCurrentUser();
        $lastFeedbackId = $this->getLastFeedbackId($user);
        $this->get('/feedbacks/edit/' . $lastFeedbackId);
        $this->client->submitForm('Envoyer', [
            'feed_back[stars]' => '5',
            'feed_back[comment]' => 'Nouveau commentaire'
        ]);
        self::assertResponseRedirects('/myFeedbacks');
        $this->get('/myFeedbacks');
        self::assertAnySelectorTextSame('td', 'Nouveau commentaire');
    }

    public function testAddFeedbacks(): void
    {
        $this->login();
        $this->get('/bookshelf');
        self::assertSelectorTextSame('H1', 'Ma bibliothèque');
        $user = $this->getCurrentUser();
        $lastFeedbackId = $this->getFormatForFeedbackTest($user);
        $this->get('/feedbacks/add/' . $lastFeedbackId);
        $this->client->submitForm('Envoyer', [
            'feed_back[stars]' => '5',
            'feed_back[comment]' => 'Premier commentaire'
        ]);
        self::assertResponseRedirects('/bookshelf');
        $this->get('/bookshelf');
        self::assertAnySelectorTextSame('li.none', 'Premier commentaire');
    }
}
