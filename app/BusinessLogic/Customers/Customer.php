<?php

namespace App\BusinessLogic\Customers;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'phone', 'city', 'street_address'];
}
