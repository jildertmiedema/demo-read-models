<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Searching;

use Elasticsearch\Client;

final class ElasticSearchSearchRepository implements SearchRepository
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $term
     *
     * @return SearchResult[]
     */
    public function search(string $term): array
    {
        $results = $this->client->search([
            'index' => 'demo',
            'type' => 'search_all',
            'body' => [
                'query' => [
                    'match' => [
                        'text' => $term
                    ]
                ]
            ]
        ]);

        return collect(array_get($results, 'hits.hits'))
            ->map(function ($data) {
                return $data['_source'] + ['relevance' => $data['_score']];
            })
            ->map(mapTo(SearchResult::class))
            ->toArray();
    }
}
