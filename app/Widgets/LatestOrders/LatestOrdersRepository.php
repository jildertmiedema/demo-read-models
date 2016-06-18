<?php

namespace App\Widgets\LatestOrders;

interface LatestOrdersRepository
{
    /**
     * @param $amount
     *
     * @return Order[]
     */
    public function latest(int $amount) : array;
}
