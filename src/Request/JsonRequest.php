<?php

namespace App\Request;

class JsonRequest
{
    public static function get()
    {
        return json_decode(file_get_contents('php://input'), true);
    }
}