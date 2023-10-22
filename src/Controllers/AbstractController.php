<?php

namespace App\Controllers;

use App\Rsponse\JsonErrorResponse;
use App\Storage\AbstractStorage;

abstract class AbstractController
{
    protected AbstractStorage $storage;

    /**
     * @param AbstractStorage $storage
     */
    public function __construct(AbstractStorage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return void
     */
    protected function auth(): void
    {
        $headers = getallheaders();
        if (!isset($headers['X-Auth-Key']) || !in_array($headers['X-Auth-Key'], AUTH_TOKENS_ARR)) {
            die(new JsonErrorResponse('Access is denied', 403));
        }
    }
}
