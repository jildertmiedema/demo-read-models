<?php

namespace App\Widgets\Search\Indexing;

use Illuminate\Database\Eloquent\Model;

class SearchItemModel extends Model
{
    protected $table = 'search_items';

    protected $fillable = ['title', 'short', 'text', 'type', 'link', 'item_id'];
}
