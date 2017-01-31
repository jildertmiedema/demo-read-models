<?php

namespace App\Console\Commands;

use App\Widgets\SalesTodoList\MemoryTableBuilder;
use Illuminate\Console\Command;

class TodoListGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'todo:generate';

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
    public function handle()
    {
        app(MemoryTableBuilder::class)->run();
    }
}
