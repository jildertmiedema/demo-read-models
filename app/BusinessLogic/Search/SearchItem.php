<?php

namespace App\BusinessLogic\Search;

use Illuminate\Database\Eloquent\Model;

class SearchItem extends Model
{
    protected $table = 'search_items';

    protected $fillable = ['title', 'short', 'text', 'type', 'link', 'item_id'];
}
