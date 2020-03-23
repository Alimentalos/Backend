<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

/**
 * Class ConvertStringShapes
 */
class ConvertStringShape extends TransformsRequest
{
    /**
     * @param string $key
     * @param mixed $value
     * @return bool|mixed
     */
    protected function transform($key, $value)
    {
        if ($key === 'shape' && is_string($value)) {
            return array_map(function($element) {
                $subExploded = explode(',', $element);
                return [
                    'latitude' => $subExploded[0],
                    'longitude' => $subExploded[1]
                ];
            },  explode('|', $value));
        }
        return $value;
    }
}
