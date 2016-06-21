<?php

namespace App\Widgets\LatestOrders;

use Predis\Client as PredisClient;

class RedisLatestOrdersRepository implements LatestOrdersRepository
{
    /**
     * @var LatestOrdersRepository
     */
    private $latestOrdersRepository;
    /**
     * @var PredisClient
     */
    private $redis;

    public function __construct(
        LatestOrdersRepository $latestOrdersRepository,
        PredisClient $redis
    ) {
        $this->latestOrdersRepository = $latestOrdersRepository;
        $this->redis = $redis;
    }

    /**
     * @param $amount
     *
     * @return Order[]
     */
    public function latest(int $amount) : array
    {
        $key = 'latest-orders-' . $amount;
        $value = $this->redis->get($key);
        if ($value) {
            return collect(json_decode($value, true))
                ->map(function (array $data) {
                    $order = new Order();
                    foreach ($data as $field => $value) {
                        $order->$field = $value;
                    }
                    return $order;
                })
                ->toArray();
        }

        $value = $this->latestOrdersRepository->latest($amount);
        $this->redis->set($key, json_encode($value));
        $this->redis->expire($key, 20);

        return $value;
    }
}
