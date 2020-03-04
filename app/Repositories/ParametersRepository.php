<?php

namespace App\Repositories;

use Illuminate\Http\Request;

class ParametersRepository
{
    public static function fillPropertiesWithRelated(Request $request, $properties, $resource)
    {
        $arr = [];
        foreach ($properties as $property){
            $arr[$property] = FillRepository::fillMethod($request, $property, $resource->{$property});
        }
        return $arr;
    }
}
