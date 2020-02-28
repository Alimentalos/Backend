<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

/**
 * Class ConvertStringBooleans
 * @package App\Http\Middleware
 * @description This class was created to support Http Form Data requests using boolean string values.
 */
class ConvertStringBooleans extends TransformsRequest
{
    /**
     * Check if value is true.
     *
     * @param $value
     * @return bool
     */
    protected function isTrue($value)
    {
        return $value === 'true' || $value === 'TRUE';
    }

    /**
     * Check if value is false.
     *
     * @param $value
     * @return bool
     */
    protected function isFalse($value) {
        return $value === 'false' || $value === 'FALSE';
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return bool|mixed
     */
    protected function transform($key, $value)
    {
        if ($key === 'is_public' && $this->isTrue($value)) {
            return true;
        }

        if ($key === 'is_public' && $this->isFalse($value)) {
            return false;
        }

        return $value;
    }
}
