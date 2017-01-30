<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Indexing;

interface SearchIndexer
{
    public function index(SearchItem $item): void;

    public function renew();
}
