<?php

namespace App;

class Database
{
    private static $instance;

    private function __construct() {}

    public static function getConnection(): \PDO
    {
        if (null === self::$instance) {
            $config = require './config/database.php';

            try {
                self::$instance = new \PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['username'], $config['password']);
            } catch (\PDOException $e) {
                http_response_code(500);
                echo json_encode([
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ]);
                die();
            }
        }

        return self::$instance;


    }
}