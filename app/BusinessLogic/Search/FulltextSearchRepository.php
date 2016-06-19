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
        return collect(\DB::table('search_items')
            ->select('*', \DB::raw('MATCH(text) AGAINST("'.$term.'" IN BOOLEAN MODE) as relevance'))
            ->whereRaw('MATCH(text) AGAINST(? IN BOOLEAN MODE)', [$term])
            ->get())
            ->map(function ($item) {
                $result = new SearchResult();
                $result->title = $item->title;
                $result->short = $item->short;
                $result->type = $item->type;
                $result->link = $item->link;
                $result->relevance = $item->relevance;

                return $result;
            })
            ->toArray();
    }
}
