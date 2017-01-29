<?php
declare(strict_types = 1);

namespace App\Widgets\LatestOrders;

use App\BusinessLogic\Orders\EloquentOrderRepository;
use App\BusinessLogic\Orders\OrderRepository;
use Illuminate\Support\ServiceProvider;

final class LatestOrderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
        $this->app->bind(LatestOrdersRepository::class, RedisReadOnlyLatestOrdersRepository::class);
        $this->app->bind('widgets.latest-orders.db', DbLatestOrdersRepository::class);
        $this->app->when(RedisLatestOrdersRepository::class)
            ->needs(LatestOrdersRepository::class)
            ->give('widgets.latest-orders.db');
        $this->app->when(RedisOrdersIndexer::class)
            ->needs(LatestOrdersRepository::class)
            ->give('widgets.latest-orders.db');
    }
}
