<?php

namespace App\Tests\Functional;

use App\Tests\FunctionalTestCase;
use Meilisearch\Endpoints\Indexes;
use Meilisearch\Search\SearchResult;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SearchControllerTest extends FunctionalTestCase
{
    public function testSearchPageLoadsSuccessfully(): void
    {
        $this->get('/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button.material-symbols-outlined', 'search');
    }

    public function testSearchWithKeywordDisplaysResults(): void
    {
        // Mock de Meilisearch
        $mockedResults = [
            'hits' => [
                [
                    'objectID' => 4,
                    'id' => 4,
                    'title' => "L'armée sans Prince 2 - Catholique et Royale",
                    'cover' => 'l-armee-sans-prince-tome-2-catholique-et-royale.jpg',
                    'summary' => 'Unde modi ut ut...',
                    'genre' => 'et',
                    'parutionDate' => 1746741600,
                    'keyWords' => [
                        ['tag' => 'occaecati-ut'],
                        ['tag' => 'molestiae-dolores'],
                        ['tag' => 'non-rerum'],
                    ],
                    'categories' => [
                        ['name' => 'Classiques'],
                        ['name' => 'Fantasy, SF'],
                        ['name' => 'Théâtre'],
                        ['name' => 'Contes et nouvelles'],
                    ],
                    'formats' => [
                        [
                            'ISBN' => '9797336767073',
                            'duration' => 79,
                            'wordsCount' => 91019,
                            'pagesCount' => 604,
                            'type' => [
                                'typeImg' => 'headphones',
                                'name' => 'Audio',
                            ],
                            'priceHT' => '5.52',
                        ]
                    ],
                    'editor' => [
                        'id' => 2,
                        'name' => 'Amphora',
                    ],
                    'boSkCos' => [
                        [
                            'contributor' => [
                                'lastname' => 'Shearer',
                                'firstname' => 'Lyonel',
                            ],
                            'skill' => [
                                'name' => 'Auteur',
                            ]
                        ]
                    ]
                ]
            ],
            'hitsPerPage' => 20,
            'offset' => 0,
            'limit' => 20,
            'processingTimeMs' => 1,
            'query' => 'livre',
            'estimatedTotalHits' => 1,
            1
        ];

        $mockIndex = $this->createMock(Indexes::class);
        $mockIndex->method('search')
            ->willReturn(new SearchResult($mockedResults));

        $mockClient = $this->createMock(\Meilisearch\Client::class);
        $mockClient->method('index')
            ->with('app_dev_books')
            ->willReturn($mockIndex);

        // Remplacer le service dans le container
        static::getContainer()->set(\Meilisearch\Client::class, $mockClient);

        $this->get('/search?keyword=prince');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.search-results'); // adapte à ta classe CSS
        $this->assertSelectorTextContains('p.book-title', 'L\'armée sans Prince 2 - Catholique et Royale');
    }
}
