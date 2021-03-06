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
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(
        LatestOrdersRepository $latestOrdersRepository,
        PredisClient $redis,
        Serializer $serializer
    ) {
        $this->latestOrdersRepository = $latestOrdersRepository;
        $this->redis = $redis;
        $this->serializer = $serializer;
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
            return $this->serializer->deserialize($value);
        }
        $orders = $this->latestOrdersRepository->latest($amount);
        $this->redis->set($key, $this->serializer->serialize($orders));
        $this->redis->expire($key, 20);

        return $orders;
    }

}
