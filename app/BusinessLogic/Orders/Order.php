<?php

namespace App\BusinessLogic\Orders;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['customer_name', 'date'];

    protected $casts = [
        'date' => 'date',
    ];

    public function lines()
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }

    public function total() : float
    {
        return $this->lines
            ->map(function (OrderLine $line) {
                return $line->amount * $line->piece_price;
            })
            ->sum();
    }
}
