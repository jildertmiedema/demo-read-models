<?php
declare(strict_types = 1);

namespace App\Widgets\Search;

use App\Widgets\Search\Indexing\ElasticSearchSearchIndexer;
use App\Widgets\Search\Indexing\EloquentSearchIndexer;
use App\Widgets\Search\Indexing\SearchIndexer;
use App\Widgets\Search\Searching\ElasticSearchSearchRepository;
use App\Widgets\Search\Searching\EloquentSearchRepository;
use App\Widgets\Search\Searching\FulltextSearchRepository;
use App\Widgets\Search\Searching\SearchRepository;
use Illuminate\Support\ServiceProvider;

final class SearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $mode = 'elasticsearch';
//        $mode = 'eloquent';
//        $mode = 'fulltext';
        if ($mode == 'elasticsearch') {
            $this->app->bind(SearchRepository::class, ElasticSearchSearchRepository::class);
            $this->app->bind(SearchIndexer::class, ElasticSearchSearchIndexer::class);
        }
        if ($mode == 'eloquent') {
            $this->app->bind(SearchRepository::class, EloquentSearchRepository::class);
            $this->app->bind(SearchIndexer::class, EloquentSearchIndexer::class);
        }
        if ($mode == 'fulltext') {
            $this->app->bind(SearchRepository::class, FulltextSearchRepository::class);
            $this->app->bind(SearchIndexer::class, EloquentSearchIndexer::class);
        }
    }
}
