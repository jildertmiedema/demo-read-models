<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Indexing\Indexers;

use App\BusinessLogic\Catalog\Product;
use App\Widgets\Search\Indexing\SearchIndexer;
use App\Widgets\Search\Indexing\SearchItem;

final class ProductIndexer
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
        iterator_each(Product::query()->cursor(), function (Product $product) {
            $link = route('product.view', $product->id, false);
            $this->indexer->index(new SearchItem(
                $product->name,
                (string) view('search.product', compact('product', 'link')),
                implode("\n", $product->toArray()),
                'product',
                $link,
                $product->id
            ));
        });
    }
}
