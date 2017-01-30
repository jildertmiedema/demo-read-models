<?php

namespace App\Console\Commands;

use App\Widgets\Search\Indexing\Indexers\CustomerIndexer;
use App\Widgets\Search\Indexing\Indexers\ProductIndexer;
use App\Widgets\Search\Indexing\Indexers\ProjectIndexer;
use App\Widgets\Search\Indexing\Indexers\UserIndexer;
use App\Widgets\Search\Indexing\SearchIndexer;
use Illuminate\Console\Command;

class CreateSearchItems extends Command
{
    /**
     * @var SearchIndexer
     */
    private $indexer;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(SearchIndexer $indexer)
    {
        $this->indexer = $indexer;
        $this->indexer->renew();

        app(CustomerIndexer::class)->run();
        app(ProductIndexer::class)->run();
        app(ProjectIndexer::class)->run();
        app(UserIndexer::class)->run();

        $this->line("real: ".(memory_get_peak_usage(true)/1024/1024)." MiB");
    }
}
