<?php

namespace App\Repositories;

class FillRepository
{
    public static function fillMethod($a, $b, $c)
    {
        return $a->has($b) ? $a->input($b) : $c;
    }
}