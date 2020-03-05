<?php

namespace App\Repositories;

class FillRepository
{
    /**
     * Fill using request attribute or default value.
     *
     * @param $attribute
     * @param $default
     * @return mixed
     */
    public static function fillAttribute($attribute, $default)
    {
        return request()->has($attribute) ? input($attribute) : $default;
    }
}
