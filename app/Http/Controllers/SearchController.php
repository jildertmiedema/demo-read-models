<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Search\SearchRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @var SearchRepository
     */
    private $search;

    public function __construct(SearchRepository $search)
    {
        $this->search = $search;
    }
    
    public function search(Request $request)
    {
        $term = $request->input('q', '');
        $results = $this->search->search($term);

        return view('search.results', compact('results', 'term'));
    }

    public function searchFulltext(Request $request)
    {
        $term = $request->input('q', '');
        $results = app('search.full-text')->search($term);

        return view('search.results', compact('results', 'term'));
    }
}
