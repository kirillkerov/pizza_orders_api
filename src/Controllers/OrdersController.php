<?php

namespace App\Controllers;

use App\Services\OrderService\DatabaseOrderService;
use App\Services\OrderService\FIleOrderService;

class OrdersController extends AbstractServiceController
{
    protected string $fileServiceName = FIleOrderService::class;
    protected string $databaseServiceName = DatabaseOrderService::class;

    public function list(string $done = null): void
    {
        $this->auth();

        if (!in_array($done, ['0', '1', null])) {
            http_response_code(400);
            throw new \InvalidArgumentException('Invalid contents in ?done');
        }

        if (!count($orders = $this->service->list($done))) {
            http_response_code(404);
            throw new \InvalidArgumentException('Not found orders');
        }

        echo json_encode($orders);
    }

    public function create(): void
    {
        $request = json_decode(file_get_contents('php://input'), true);
        if (!isset($request['items'])) {
            http_response_code(400);
            throw new \InvalidArgumentException('Request must contain an array of items');
        }
        $this->validateItemsArray($request['items']);

        $order = $this->service->create($request['items']);
        http_response_code(201);

        echo json_encode($order);
    }

    public function append(string $order_id): void
    {
        $items = json_decode(file_get_contents('php://input'), true);
        $this->validateItemsArray($items);

        $this->service->append($order_id, $items);
    }

    public function get(string $order_id): void
    {
        $order = $this->service->get($order_id);

        echo json_encode($order);
    }

    public function done(string $order_id)
    {
        $this->auth();

        $this->service->done($order_id);
    }

    private function auth(): void
    {
        $headers = getallheaders();
        if (!isset($headers['X-Auth-Key']) || !in_array($headers['X-Auth-Key'], AUTH_TOKENS_ARR)) {
            http_response_code(403);
            die(json_encode(['error' => 'Access is denied']));
        }
    }

    private function validateItemsArray($items): void
    {
        if (!is_array($items) || !count($items)) {
            http_response_code(400);
            throw new \InvalidArgumentException('Items must be an array');
        }

        foreach ($items as $item) {
            if (!is_int($item) || $item < 1 || $item > 5000) {
                http_response_code(400);
                throw new \InvalidArgumentException('Items must be an array of integers from 1 to 5000');
            }
        }
    }
}
