<?php

namespace App\BusinessLogic\Sales;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'sales_projects';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
