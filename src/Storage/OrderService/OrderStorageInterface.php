<?php

namespace App\Storage\OrderService;

interface OrderStorageInterface
{
    /**
     * @param string|null $done
     * @return array
     */
    public function list(string $done = null): array;

    /**
     * @param string $order_id
     * @return array|null
     */
    public function get(string $order_id): ?array;

    /**
     * @param array $items
     * @return array|null
     */
    public function create(array $items): ?array;

    /**
     * @param string $order_id
     * @param array $items
     * @return void
     */
    public function append(string $order_id, array $items): void;

    /**
     * @param $order_id
     * @return void
     */
    public function done($order_id): void;
}