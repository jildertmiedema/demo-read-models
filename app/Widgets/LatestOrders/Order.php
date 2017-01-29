<?php

namespace App\Widgets\LatestOrders;

class Order
{
    private $customerName;
    private $date;
    private $total;

    public function __construct($customerName, $date, $total)
    {
        $this->customerName = $customerName;
        $this->date = $date;
        $this->total = $total;
    }

    public function customerName()
    {
        return $this->customerName;
    }

    public function date()
    {
        return $this->date;
    }

    public function total()
    {
        return $this->total;
    }

}
