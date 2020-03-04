<?php

namespace App\Repositories;

class ParametersRepository
{
    /**
     * @param $properties
     * @param $resource
     * @return array
     */
    public function fillPropertiesUsingResource($properties, $resource)
    {
        $arr = [];
        foreach ($properties as $property){
            $arr[$property] = FillRepository::fillAttribute($property, $resource->{$property});
        }
        return $arr;
    }
}
