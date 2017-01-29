<?php

namespace App\Widgets\LatestOrders;

use App\BusinessLogic\Orders\Order as OrderModel;

class EloquentLatestOrdersRepository implements LatestOrdersRepository
{

    /**
     * @param $amount
     *
     * @return Order[]
     */
    public function latest(int $amount) : array
    {
        return OrderModel::orderBy('date', 'desc')
            ->with('lines')
            ->limit($amount)
            ->get()
            ->map(function (OrderModel $e) {
                return new Order($e->customer_name, $e->date->format('d-m-Y'), $e->total());
            })
            ->toArray();
    }
}
