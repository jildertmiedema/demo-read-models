<?php
declare(strict_types = 1);

namespace App\Widgets\Search;

use App\BusinessLogic\Search\ElasticSearchSearchRepository;
use App\BusinessLogic\Search\SearchRepository;
use Illuminate\Support\ServiceProvider;

final class SearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SearchRepository::class, ElasticSearchSearchRepository::class);
        $this->app->bind(SearchIndexer::class, ElasticSearchSearchIndexer::class);
    }
}
