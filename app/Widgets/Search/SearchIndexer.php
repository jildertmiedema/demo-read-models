<?php
declare(strict_types = 1);

namespace App\Widgets\Search;

use App\BusinessLogic\Search\SearchItem;

interface SearchIndexer
{
    public function index(SearchItem $item): void;

    public function renew();
}
