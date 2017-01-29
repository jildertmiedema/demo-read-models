<?php

namespace App\Widgets\LatestOrders;

use Predis\Client as PredisClient;

class RedisOrdersIndexer
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

    public function index()
    {
        $amount = 5;
        $ttl = 120;

        $key = 'latest-orders-' . $amount;

        $orders = $this->latestOrdersRepository->latest($amount);
        $this->redis->set($key, $this->serializer->serialize($orders));
        $this->redis->expire($key, $ttl);
    }

}
