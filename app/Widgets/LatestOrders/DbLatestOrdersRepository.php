<?php

namespace App\Widgets\LatestOrders;

use Illuminate\Database\Connection;

class DbLatestOrdersRepository implements LatestOrdersRepository
{

    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    /**
     * @param $amount
     *
     * @return Order[]
     */
    public function latest(int $amount) : array
    {
        return collect($this->connection->select('
                SELECT customer_name, date, sum(line.amount * line.piece_price) as total 
                FROM orders
                INNER JOIN order_lines line ON line.order_id = orders.id
                GROUP BY orders.id
                ORDER by date DESC 
                LIMIT 0, ' . $amount
            ))
            ->map(function ($row) {
                return new Order($row->customer_name, $row->date, $row->total);
            })
            ->toArray();
    }
}
