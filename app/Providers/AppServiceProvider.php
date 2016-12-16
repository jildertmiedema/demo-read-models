<?php

namespace App\Providers;

use App\BusinessLogic\Orders\EloquentOrderRepository;
use App\BusinessLogic\Orders\OrderRepository;
use App\BusinessLogic\Search\EloquentSearchRepository;
use App\BusinessLogic\Search\FulltextSearchRepository;
use App\BusinessLogic\Search\SearchRepository;
use App\Widgets\LatestOrders\DbLatestOrdersRepository;
use App\Widgets\LatestOrders\EloquentLatestOrdersRepository;
use App\Widgets\LatestOrders\LatestOrdersRepository;
use App\Widgets\LatestOrders\RedisLatestOrdersRepository;
use App\Widgets\SalesTodoList\BuilderTodoListRepository;
use App\Widgets\SalesTodoList\InMemoryTodoListRepository;
use App\Widgets\SalesTodoList\TimeClassDecorator;
use App\Widgets\SalesTodoList\TodoListRepository;
use App\Widgets\SalesTodoList\ViewTodoListRepository;
use Illuminate\Support\Collection;
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
        $this->app->bind(LatestOrdersRepository::class, EloquentLatestOrdersRepository::class);
        $this->app->bind('widgets.latest-orders.redis', function () {
            $redis = $this->app->make(Client::class);

            return new RedisLatestOrdersRepository(new EloquentLatestOrdersRepository(), $redis);
        });
        $this->app->bind('widgets.latest-orders.db', DbLatestOrdersRepository::class);
        $this->app->bind(SearchRepository::class, EloquentSearchRepository::class);
        $this->app->bind('search.full-text', FulltextSearchRepository::class);
        $this->app->bind(TodoListRepository::class, function () {
            $repo = $this->app->make(BuilderTodoListRepository::class);

            return new TimeClassDecorator($repo);
        });

        $this->app->bind('widget-todo.repo.in-memory', function () {
            $repo = $this->app->make(InMemoryTodoListRepository::class);

            return new TimeClassDecorator($repo);
        });

        $this->app->bind('widget-todo.repo.view', function () {
            $repo = $this->app->make(ViewTodoListRepository::class);

            return new TimeClassDecorator($repo);
        });

        $this->app->singleton('queries', function () {
            return new Collection();
        });

        \DB::listen(function ($sql) {
            $this->app['queries']->push($sql->sql);
        });
    }
}
