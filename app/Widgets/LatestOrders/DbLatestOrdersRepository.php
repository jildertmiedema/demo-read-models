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
                SELECT customer_name, date, sum(lines.amount * lines.piece_price) as total 
                FROM orders
                INNER JOIN order_lines lines ON lines.order_id = orders.id
                GROUP BY orders.id
                ORDER by date DESC 
                LIMIT 0,5
            '))
            ->map(function ($row) {
                return new Order($row->customer_name, $row->date, $row->total);
            })
            ->toArray();
    }
}
