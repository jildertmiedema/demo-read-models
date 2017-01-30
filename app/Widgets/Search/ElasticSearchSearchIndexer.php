<?php
declare(strict_types = 1);

namespace App\Widgets\Search;

use App\BusinessLogic\Search\SearchItem;
use Elasticsearch\Client;

final class ElasticSearchSearchIndexer implements SearchIndexer
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index(SearchItem $item): void
    {
        $this->client->index([
            'index' => 'demo',
            'type' => 'search_all',
            'body' => $item->toArray(),
            'id' => $item->type . '_' . $item->item_id,
        ]);
    }

    public function renew()
    {
        $this->client->indices()->delete([
            'index' => 'demo',
        ]);
    }
}
