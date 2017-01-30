<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Indexing\Indexers;

use App\BusinessLogic\Customers\Customer;
use App\Widgets\Search\Indexing\SearchIndexer;
use App\Widgets\Search\Indexing\SearchItem;

final class CustomerIndexer
{
    /**
     * @var SearchIndexer
     */
    private $indexer;

    public function __construct(SearchIndexer $indexer)
    {
        $this->indexer = $indexer;
    }

    public function run()
    {
        iterator_each(Customer::query()->cursor(), function (Customer $customer) {
            $link = route('customer.view', $customer->id, false);
            $short = (string)view('search.customer', compact('customer', 'link'));
            $textToSearchIn = implode("\n", $customer->toArray());

            $this->indexer->index(new SearchItem(
                $customer->name, //title
                $short,
                $textToSearchIn,
                'customer', //type
                $link,
                $customer->id
            ));
        });
    }
}
