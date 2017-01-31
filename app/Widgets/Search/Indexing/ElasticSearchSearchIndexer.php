<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Indexing;

use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use GeneratedHydrator\Configuration;
use Zend\Hydrator\HydratorInterface;

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
            'body' => $this->serialize($item),
            'id' => $item->type() . '_' . $item->itemId(),
        ]);
    }

    public function clear()
    {
        try {
            $this->client->indices()->delete([
                'index' => 'demo',
            ]);
        } catch (Missing404Exception $exception) {
            //this is ok
        }
    }

    private function hydrator(): HydratorInterface
    {
        $config = new Configuration(SearchItem::class);
        $class = $config->createFactory()->getHydratorClass();

        return new $class;
    }

    private function serialize(SearchItem $item): array
    {
        return $this->hydrator()->extract($item);
    }
}
