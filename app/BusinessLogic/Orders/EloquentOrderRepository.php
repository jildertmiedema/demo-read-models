<?php

namespace App\BusinessLogic\Orders;

class EloquentOrderRepository implements OrderRepository
{

    public function latest(int $amount)
    {
        return Order::orderBy('date', 'desc')
            ->limit($amount)
            ->get();
    }
}
