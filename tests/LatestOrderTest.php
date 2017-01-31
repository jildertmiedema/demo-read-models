<?php

use App\BusinessLogic\Orders\Order;
use App\BusinessLogic\Orders\OrderLine;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LatestOrderTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testOrderOnDashboard()
    {
        factory(Order::class, 1)
            ->create([
                'customer_name' => 'demo customer'
            ])
            ->each(function (Order $order) {
                $lines = factory(OrderLine::class, 2)->make([
                    'amount' => 1,
                    'piece_price' => 1,
                ]);
                $order->lines()->saveMany($lines);
            });
        $this->visit('/dashboard')
             ->see('demo customer')
             ->see('€ 2.00');
    }
}
