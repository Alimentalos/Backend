<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class ParametersRepository
{
    /**
     * Fill array with a list using model properties
     *
     * @param array $properties
     * @param Model $resource
     * @return array
     */
    public function fill($properties, Model $resource)
    {
        $arr = [];
        foreach ($properties as $prop){
            $arr[$prop] = fill($prop, $resource->{$prop});
        }
        return $arr;
    }
}
