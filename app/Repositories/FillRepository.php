<?php

namespace App\Repositories;

use Illuminate\Http\Request;

class FillRepository
{
    /**
     * Fill using request attribute or default value.
     *
     * @param Request $request
     * @param $attribute
     * @param $default
     * @return mixed
     */
    public static function fillMethod(Request $request, $attribute, $default)
    {
        return $request->has($attribute) ? $request->input($attribute) : $default;
    }
}
