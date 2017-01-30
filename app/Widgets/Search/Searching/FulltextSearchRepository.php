<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Searching;

use Illuminate\Database\Connection;

class FulltextSearchRepository implements SearchRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $term
     *
     * @return SearchResult[]
     */
    public function search(string $term) : array
    {
        return collect($this->connection->select('
                SELECT *, MATCH(text) AGAINST(? IN BOOLEAN MODE) as relevance 
                FROM search_items
                WHERE MATCH (text) AGAINST(? IN BOOLEAN MODE)
                ', [$term, $term]))
            ->map(mapTo(SearchResult::class))
            ->toArray();
    }
}
