<?php

namespace App\Http\Controllers;

use App\BusinessLogic\Orders\OrderRepository;
use App\Widgets\LatestOrders\LatestOrdersRepository;

class DashboardController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orders;
    /**
     * @var LatestOrdersRepository
     */
    private $latestOrders;

    public function __construct(
        OrderRepository $orderRepository,
        LatestOrdersRepository $latestOrders

    ) {
        $this->orders = $orderRepository;
        $this->latestOrders = $latestOrders;
    }
    
    public function dashboard()
    {
        $orders = $this->orders->latest(5);
        $latestOrders = $this->latestOrders->latest(5);

        return view('dashboard', compact('orders', 'latestOrders'));
    }
}
