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

        return view('dashboard', compact('orders'));
    }

    public function dashboardRead()
    {
        $orders = $this->latestOrders->latest(5);

        return view('dashboard-read', compact('orders'));
    }

    public function dashboardRedis()
    {
        $orders = app('widgets.latest-orders.redis')->latest(5);

        return view('dashboard-read', compact('orders'));
    }

    public function dashboardDb()
    {
        $orders = app('widgets.latest-orders.db')->latest(5);

        return view('dashboard-read', compact('orders'));
    }
}
