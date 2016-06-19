<?php

namespace App\Console\Commands;

use App\BusinessLogic\Catalog\Product;
use App\BusinessLogic\Customers\Customer;
use App\BusinessLogic\Search\SearchItem;
use Illuminate\Console\Command;

class CreateSearchItems extends Command
{
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
    public function handle()
    {
        SearchItem::all()->map(function ($item) {
            $item->delete();
        });
        Customer::all()->map(function (Customer $customer) {
            $link = route('customer.view', $customer->id);
            SearchItem::create([
                'title' => $customer->name,
                'short' => (string) view('search.customer', compact('customer', 'link')),
                'text' => implode("\n", $customer->toArray()),
                'type' => 'customer',
                'link' => $link,
                'item_id' => $customer->id,
            ]);
        });
        Product::all()->map(function (Product $product) {
            $link = route('customer.view', $product->id);
            SearchItem::create([
                'title' => $product->name,
                'short' => (string) view('search.product', compact('product', 'link')),
                'text' => implode("\n", $product->toArray()),
                'type' => 'product',
                'link' => $link,
                'item_id' => $product->id,
            ]);
        });
    }
}
