<?php

namespace App\Storage\OrderService;

use App\Storage\AbstractDatabaseStorage;

class DatabaseOrderStorage extends AbstractDatabaseStorage implements OrderStorageInterface
{
    /**
     * @param string|null $done
     * @return array
     */
    public function list(string $done = null): array
    {
        $sql = match ($done) {
            '0' => "SELECT order_id, done FROM orders WHERE done is false",
            '1' => "SELECT order_id, done FROM orders WHERE done is true",
            default => "SELECT order_id, done FROM orders",
        };

        $stmt = $this->connect->query($sql);
        $orders = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $row['done'] = (bool) $row['done'];
            $orders[] = $row;
        }

        return $orders;
    }

    /**
     * @param string $order_id
     * @return array|null
     * @throws \Exception
     */
    public function get(string $order_id): ?array
    {
        $stmt = $this->connect->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->bindValue(1, $order_id, \PDO::PARAM_STR);
        $stmt->execute();

        if (!$order = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            http_response_code(404);
            throw new \Exception('Order not found');
        }

        $order['items'] = unserialize($order['items']);
        $order['done'] = (bool) $order['done'];

        return $order ?: null;
    }

    /**
     * @param array $items
     * @return array|null
     * @throws \Exception
     */
    public function create(array $items): ?array
    {
        $stmt = $this->connect->prepare("INSERT INTO orders (items) value (:items)");
        $stmt->bindValue('items', serialize($items), \PDO::PARAM_STR);
        $stmt->execute();

        return $this->get($this->connect->lastInsertId());
    }

    /**
     * @param string $order_id
     * @param array $items
     * @return void
     * @throws \Exception
     */
    public function append(string $order_id, array $items): void
    {
        $order = $this->get($order_id);

        if ($order['done']) {
            http_response_code(403);
            throw new \InvalidArgumentException('You cannot change an already done order');
        }

        $stmt = $this->connect->prepare("UPDATE orders SET items = :items WHERE order_id = :order_id");
        $stmt->bindValue('items', serialize([...$order['items'], ...$items]), \PDO::PARAM_STR);
        $stmt->bindValue('order_id', $order_id, \PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * @param $order_id
     * @return void
     * @throws \Exception
     */
    public function done($order_id): void
    {
        $order = $this->get($order_id);

        if ($order['done']) {
            http_response_code(403);
            throw new \InvalidArgumentException('The order will already done');
        }

        $stmt = $this->connect->prepare("UPDATE orders SET done = true WHERE order_id = :order_id");
        $stmt->bindValue('order_id', $order_id, \PDO::PARAM_STR);
        $stmt->execute();
    }
}
