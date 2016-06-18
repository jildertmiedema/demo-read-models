<?php

namespace App\BusinessLogic\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $table = 'order_lines';

    protected $fillable = ['amount', 'piece_price', 'description', 'order_id'];
}
