<?php

namespace App\Services;

abstract class AbstractFileService
{
    public function __construct()
    {
        if (!file_exists(STORAGE_PATH)) {
            $fo = fopen(STORAGE_PATH, 'w');
            fclose($fo);
        }
    }
}