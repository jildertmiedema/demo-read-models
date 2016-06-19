<?php

namespace App\Providers;

use App\BusinessLogic\Orders\EloquentOrderRepository;
use App\BusinessLogic\Orders\OrderRepository;
use App\BusinessLogic\Search\EloquentSearchRepository;
use App\BusinessLogic\Search\FulltextSearchRepository;
use App\BusinessLogic\Search\SearchRepository;
use App\Widgets\LatestOrders\EloquentLatestOrdersRepository;
use App\Widgets\LatestOrders\LatestOrdersRepository;
use App\Widgets\LatestOrders\RedisLatestOrdersRepository;
use Illuminate\Support\ServiceProvider;
use Predis\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once __DIR__ . '/../helpers.php';
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
//        $this->app->bind(LatestOrdersRepository::class, EloquentLatestOrdersRepository::class);
        $this->app->bind(LatestOrdersRepository::class, function () {
            $redis = $this->app->make(Client::class);

            return new RedisLatestOrdersRepository(new EloquentLatestOrdersRepository(), $redis);
        });
//        $this->app->bind(SearchRepository::class, EloquentSearchRepository::class);
        $this->app->bind(SearchRepository::class, FulltextSearchRepository::class);
    }
}
