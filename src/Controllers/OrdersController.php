<?php

namespace App\Controllers;

use App\Request\JsonRequest;
use App\Rsponse\JsonErrorResponse;
use App\Rsponse\JsonResponse;
use App\Validators\OrderValidator;

class OrdersController extends AbstractController
{
    /**
     * @param string|null $done
     * @return void
     */
    public function list(string $done = null): void
    {
        $this->auth();

        if (!in_array($done, ['0', '1', null])) {
            die(new JsonErrorResponse('Invalid contents in ?done', 400));
        }

        if (!count($orders = $this->storage->list($done))) {
            die(new JsonErrorResponse('Not found orders', 404));
        }

        echo new JsonResponse($orders);
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $request = JsonRequest::get();

        if (!isset($request['items'])) {
            die(new JsonErrorResponse('Request must contain an array of items', 400));
        }

        if (!OrderValidator::items($request['items'])) {
            die(new JsonErrorResponse('Items must be an array of integers from 1 to 5000', 400));
        }

        $order = $this->storage->create($request['items']);

        echo new JsonResponse($order, 201);
    }

    /**
     * @param string $order_id
     * @return void
     * @throws \Exception
     */
    public function append(string $order_id): void
    {
        $items = JsonRequest::get();

        if (!OrderValidator::items($items)) {
            die(new JsonErrorResponse('Items must be an array of integers from 1 to 5000', 400));
        }

        $this->storage->append($order_id, $items);
    }

    /**
     * @param string $order_id
     * @return void
     * @throws \Exception
     */
    public function get(string $order_id): void
    {
        $order = $this->storage->get($order_id);

        echo new JsonResponse($order);
    }

    /**
     * @param string $order_id
     * @return void
     * @throws \Exception
     */
    public function done(string $order_id): void
    {
        $this->auth();

        $this->storage->done($order_id);
    }
}
