<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Indexing;

use GeneratedHydrator\Configuration;
use Zend\Hydrator\HydratorInterface;

final class EloquentSearchIndexer implements SearchIndexer
{
    public function index(SearchItem $item): void
    {
        $data = $this->serialize($item);
        $data['item_id'] = $data['itemId'];
        SearchItemModel::create($data);
    }

    public function clear()
    {
        iterator_each(SearchItemModel::query()->cursor(), function (SearchItemModel $item) {
            $item->delete();
        });
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
