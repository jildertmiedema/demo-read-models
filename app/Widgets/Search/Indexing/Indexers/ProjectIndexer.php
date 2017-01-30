<?php
declare(strict_types = 1);

namespace App\Widgets\Search\Indexing\Indexers;

use App\BusinessLogic\Sales\Project;
use App\Widgets\Search\Indexing\SearchIndexer;
use App\Widgets\Search\Indexing\SearchItem;

final class ProjectIndexer
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

        iterator_each(Project::query()->cursor(), function (Project $project) {
            $link = route('project.view', $project->id, false);
            $this->indexer->index(new SearchItem(
                $project->name,
                (string) view('search.project', compact('project', 'link')),
                $project->name . "\n" . $project->user->name,
                'project',
                $link,
                $project->id
            ));
        });
    }
}
