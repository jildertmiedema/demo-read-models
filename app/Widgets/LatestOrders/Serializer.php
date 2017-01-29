<?php
declare(strict_types = 1);

namespace App\Widgets\LatestOrders;

use GeneratedHydrator\Configuration;
use Zend\Hydrator\HydratorInterface;

final class Serializer
{
    private function hydrator(): HydratorInterface
    {
        $config = new Configuration(Order::class);
        $class = $config->createFactory()->getHydratorClass();

        return new $class;
    }

    public function serialize(array $orders): string
    {
        $data = array_map(function (Order $order) {
            return $this->hydrator()->extract($order);
        }, $orders);

        return json_encode($data);
    }

    public function deserialize(string $data): array
    {
        $data = json_decode($data, true);
        $orders = array_map(function ($data) {
            $class = unserialize(
                sprintf(
                    'O:%d:"%s":0:{}',
                    strlen(Order::class), Order::class)
            );
            return $this->hydrator()->hydrate($data, $class);
        }, $data);

        return $orders;
    }
}
