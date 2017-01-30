<?php
declare(strict_types = 1);

namespace App\Widgets\Search;

use App\BusinessLogic\Search\SearchItem;

final class EloquentSearchIndexer implements SearchIndexer
{
    public function index(SearchItem $item): void
    {
        $item->save();
    }

    public function renew()
    {
        iterator_each(SearchItem::query()->cursor(), function (SearchItem $item) {
            $item->delete();
        });
    }
}
