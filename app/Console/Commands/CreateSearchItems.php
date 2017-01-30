<?php

namespace App\Console\Commands;

use App\BusinessLogic\Catalog\Product;
use App\BusinessLogic\Customers\Customer;
use App\BusinessLogic\Sales\Project;
use App\BusinessLogic\Search\SearchItem;
use App\User;
use App\Widgets\Search\SearchIndexer;
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
        iterator_each(Customer::query()->cursor(), function (Customer $customer) {
            $link = route('customer.view', $customer->id, false);
            $short = (string)view('search.customer', compact('customer', 'link'));
            $wordsToSearchIn = implode("\n", $customer->toArray());

            $this->indexer->index(new SearchItem([
                'title' => $customer->name,
                'short' => $short,
                'text' => $wordsToSearchIn,
                'type' => 'customer',
                'link' => $link,
                'item_id' => $customer->id,
            ]));
        });
        iterator_each(Product::query()->cursor(), function (Product $product) {
            $link = route('product.view', $product->id, false);
            $this->indexer->index(new SearchItem([
                'title' => $product->name,
                'short' => (string) view('search.product', compact('product', 'link')),
                'text' => implode("\n", $product->toArray()),
                'type' => 'product',
                'link' => $link,
                'item_id' => $product->id,
            ]));
        });
        iterator_each(Project::query()->cursor(), function (Project $project) {
            $link = route('project.view', $project->id, false);
            $this->indexer->index(new SearchItem([
                'title' => $project->name,
                'short' => (string) view('search.project', compact('project', 'link')),
                'text' => $project->name . "\n" . $project->user->name,
                'type' => 'project',
                'link' => $link,
                'item_id' => $project->id,
            ]));
        });
        iterator_each(User::query()->cursor(), function (User $user) {
            $link = route('user.view', $user->id, false);
            $this->indexer->index(new SearchItem([
                'title' => $user->name,
                'short' => (string) view('search.user', compact('user', 'link')),
                'text' => $user->name,
                'type' => 'user',
                'link' => $link,
                'item_id' => $user->id,
            ]));
        });
        $this->line("real: ".(memory_get_peak_usage(true)/1024/1024)." MiB");
    }
}
