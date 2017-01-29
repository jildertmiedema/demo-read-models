<?php

namespace App\Console\Commands;

use App\Widgets\LatestOrders\RedisOrdersIndexer;
use Illuminate\Console\Command;

class IndexOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index latest orders';

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
    public function handle(RedisOrdersIndexer $indexer)
    {
        $indexer->index();
    }
}
