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
                SELECT `customer_name`, `date`, sum(`order_lines`.`amount` * `order_lines`.`piece_price`) as total 
                FROM `orders`
                INNER JOIN `order_lines` ON `order_lines`.`order_id` = `orders`.`id`
                GROUP BY `orders`.`id`
                ORDER by date DESC 
                LIMIT 0,5
            '))
            ->map(mapTo(Order::class))
            ->toArray();
    }
}
