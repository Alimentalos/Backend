<?php


namespace App\Tools;


class Filler
{
    /**
     * Fill using request attribute or default value.
     *
     * @param $attribute
     * @param $default
     * @return mixed
     */
    public static function make($attribute, $default)
    {
        return request()->has($attribute) ? input($attribute) : $default;
    }
}
