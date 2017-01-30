<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Indexing\Indexers;

use App\BusinessLogic\Sales\User;
use App\Widgets\Search\Indexing\SearchIndexer;
use App\Widgets\Search\Indexing\SearchItem;

final class UserIndexer
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
        iterator_each(User::query()->cursor(), function (User $user) {
            $link = route('user.view', $user->id, false);
            $this->indexer->index(new SearchItem(
                $user->name,
                (string) view('search.user', compact('user', 'link')),
                $user->name,
                'user',
                $link,
                $user->id
            ));
        });
    }
}
