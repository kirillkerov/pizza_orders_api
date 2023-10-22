<?php

namespace App\Validators;

class OrderValidator
{
    public static function items(mixed $items): bool
    {
        if (!is_array($items) || !count($items)) {
            return false;
        }

        foreach ($items as $item) {
            if (!is_int($item) || $item < 1 || $item > 5000) {
                return false;
            }
        }

        return true;
    }
}