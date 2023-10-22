<?php

namespace App\Controllers;

use App\Services\AbstractDatabaseService;
use App\Services\AbstractFileService;

abstract class AbstractServiceController
{
    protected AbstractFileService|AbstractDatabaseService $service;
    protected string $fileServiceName;
    protected string $databaseServiceName;

    public function __construct()
    {
        $this->service = match (STORAGE_TYPE) {
            'file' => $this->getFileService(),
            'database' => $this->getDatabaseService(),
        };
    }

    protected function getFileService(): AbstractFileService
    {
        $serviceName = $this->fileServiceName;

        return new $serviceName();
    }

    protected function getDatabaseService(): AbstractDatabaseService
    {
        $serviceName = $this->databaseServiceName;

        return new $serviceName();
    }
}