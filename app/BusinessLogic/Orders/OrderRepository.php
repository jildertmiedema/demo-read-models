<?php

namespace App\BusinessLogic\Orders;

interface OrderRepository
{
    public function latest(int $amount);
}
