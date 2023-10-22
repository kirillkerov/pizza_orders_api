<?php

namespace App\Services\OrderService;

use App\Services\AbstractFileService;

class FIleOrderService extends AbstractFileService implements OrderServiceInterface
{
    public function list(string $done = null): array
    {
        $orders = [];

        $lines = file(STORAGE_PATH);
        foreach ($lines as $line) {
            $order = explode(' ', trim($line));

            if ($done === '1' && !$order[1]) {
                continue;
            }

            if ($done === '0' && $order[1]) {
                continue;
            }

            $orders[] = [
                'order_id' => $order[0],
                'done' => (bool) $order[1],
            ];
        }

        return $orders;
    }

    public function get(string $order_id): ?array
    {
        $lines = file(STORAGE_PATH);

        foreach ($lines as $line) {
            $order = explode(' ', trim($line));

            if ($order[0] == $order_id) {
                $order = [
                    'order_id' => $order[0],
                    'items' => unserialize($order[2]),
                    'done' => (bool) $order[1],
                ];

                return $order;
            }
        }

        http_response_code(404);
        throw new \Exception('Order not found');
    }

    public function create(array $items): ?array
    {
        $order_id = uniqid();
        $order = [$order_id, 0, serialize($items)];
        file_put_contents(STORAGE_PATH, implode(' ', $order) . PHP_EOL, FILE_APPEND);

        return $this->get($order_id);
    }

    public function append(string $order_id, array $items): void
    {
        $lines = file(STORAGE_PATH);

        foreach ($lines as $key => $line) {
            $order = explode(' ', trim($line));

            if ($order[0] != $order_id) {
                continue;
            }

            if ($order[1]) {
                http_response_code(403);
                throw new \InvalidArgumentException('You cannot change an already done order');
            }

            $currentItems = unserialize($order[2]);
            $order[2] = serialize([...$currentItems, ...$items]);

            $lines[$key] = implode(' ', $order) . PHP_EOL;
            file_put_contents(STORAGE_PATH, $lines);
            return;
        }

        http_response_code(404);
        throw new \Exception('Order not found');
    }

    public function done($order_id): void
    {
        $lines = file(STORAGE_PATH);

        foreach ($lines as $key => $line) {
            $order = explode(' ', trim($line));
            if ($order[0] != $order_id) {
                continue;
            }

            if ($order[1]) {
                http_response_code(403);
                throw new \InvalidArgumentException('The order will already done');
            }

            $update = [$order[0], 1, $order[2]];

            $lines[$key] = implode(' ', $update) . PHP_EOL;

            file_put_contents(STORAGE_PATH, $lines);
            return;
        }

        http_response_code(404);
        throw new \Exception('Order not found');
    }
}