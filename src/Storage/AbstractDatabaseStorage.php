<?php

namespace App\Storage;

use App\Database;

abstract class AbstractDatabaseStorage extends AbstractStorage
{
    protected \PDO $connect;

    public function __construct()
    {
        $this->connect = Database::getConnection();
    }
}