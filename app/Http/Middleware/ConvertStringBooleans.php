<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertStringBooleans extends TransformsRequest
{
    /**
     * @param string $key
     * @param mixed $value
     * @return bool|mixed
     */
    protected function transform($key, $value)
    {
        if ($key === 'is_public' && ($value === 'true' || $value === 'TRUE')) {
            return true;
        }

        if ($key === 'is_public' && ($value === 'false' || $value === 'FALSE')) {
            return false;
        }

        return $value;
    }
}
