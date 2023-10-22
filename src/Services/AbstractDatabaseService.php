<?php

namespace App\Services;

use App\Database;

abstract class AbstractDatabaseService
{
    protected \PDO $connect;

    public function __construct()
    {
        $this->connect = Database::getConnection();
    }
}