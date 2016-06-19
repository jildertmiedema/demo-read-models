<?php

namespace App\BusinessLogic\Search;

interface SearchRepository
{
    /**
     * @param string $term
     *
     * @return SearchResult[]
     */
    public function search(string $term) : array;
}
