<?php

namespace App\Widgets\LatestOrders;

use Predis\Client as PredisClient;

class RedisReadOnlyLatestOrdersRepository implements LatestOrdersRepository
{
    /**
     * @var PredisClient
     */
    private $redis;
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(
        PredisClient $redis,
        Serializer $serializer
    ) {
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
        if (!$value) {
            return [];
        }

        return $this->serializer->deserialize($value);
    }

}
