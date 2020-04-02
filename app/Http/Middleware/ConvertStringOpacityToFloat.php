<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertStringOpacityToFloat extends TransformsRequest
{
    /**
     * @param string $key
     * @param mixed $value
     * @return bool|mixed
     */
    protected function transform($key, $value)
    {
        if ($key === 'fill_opacity' && is_string($value)) {
            return (float) $value;
        }
        return $value;
    }
}
