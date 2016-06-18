<?php

use App\BusinessLogic\Orders\Order;
use App\BusinessLogic\Orders\OrderLine;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Order::class, 30)
            ->create()
            ->each(function (Order $order) {
                $lines = factory(OrderLine::class, rand(1, 10))->make();
                $order->lines()->saveMany($lines);
            });
    }
}
