<?php

namespace App\Widgets\Search\Searching;

use App\Widgets\Search\Indexing\SearchItemModel;

class EloquentSearchRepository implements SearchRepository
{

    /**
     * @param string $term
     *
     * @return SearchResult[]
     */
    public function search(string $term) : array
    {
        $terms = explode(' ', $term);
        $terms = array_map('trim', $terms);
        $terms = array_filter($terms);
        if (count($terms) === 0 ) {
            return [];
        }
        $builder = SearchItemModel::query();
        foreach ($terms as $term) {
            $term = str_replace('%%', '%', $term);
            $term = sprintf('%%%s%%', $term);
            $builder->where('text', 'like', $term);
        }
        
        return $builder
            ->limit(100)
            ->get()
            ->map(mapTo(SearchResult::class))
            ->toArray();
    }
}
