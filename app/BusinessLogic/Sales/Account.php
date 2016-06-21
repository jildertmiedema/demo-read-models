<?php

namespace App\BusinessLogic\Sales;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'sales_accounts';

    protected $fillable = ['name', 'phone', 'site'];
}
