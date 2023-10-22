<?php

namespace App\Services\OrderService;

interface OrderServiceInterface
{
    public function list(string $done = null): array;

    public function get(string $order_id): ?array;

    public function create(array $items): ?array;

    public function append(string $order_id, array $items): void;

    public function done($order_id): void;
}