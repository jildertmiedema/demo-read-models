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
            ->limit($amount)
            ->get()
            ->map(function (OrderModel $orderModel) {
                $order = new Order;
                $order->customerName = $orderModel->customer_name;
                $order->date = $orderModel->date->format('d-m-Y');
                $order->total = $orderModel->total();

                return $order;
            })
            ->toArray();
    }
}
