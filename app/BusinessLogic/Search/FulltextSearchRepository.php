<?php

namespace App\BusinessLogic\Search;

class FulltextSearchRepository implements SearchRepository
{

    /**
     * @param string $term
     *
     * @return SearchResult[]
     */
    public function search(string $term) : array
    {
        return collect(\DB::select('
                SELECT *, MATCH(text) AGAINST(? IN BOOLEAN MODE) as relevance 
                FROM search_items
                WHERE MATCH(text) AGAINST(? IN BOOLEAN MODE)
                ', [$term, $term]))
            ->map(mapTo(SearchResult::class))
            ->toArray();
    }
}
