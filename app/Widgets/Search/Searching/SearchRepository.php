<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Searching;

interface SearchRepository
{
    /**
     * @param string $term
     *
     * @return SearchResult[]
     */
    public function search(string $term) : array;
}
