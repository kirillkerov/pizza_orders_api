<?php

namespace App\Storage;

abstract class AbstractFileStorage extends AbstractStorage
{
    public function __construct()
    {
        if (!file_exists(STORAGE_PATH)) {
            $fo = fopen(STORAGE_PATH, 'w');
            fclose($fo);
        }
    }
}