<?php


namespace App\Procedures;


use App\Repositories\UniqueNameRepository;

trait ActionProcedure
{
    /**
     * Create parameters for action create.
     *
     * @param $type
     * @param $parameters
     * @param $resource
     * @param null $referenced
     * @return array
     */
    public function parameters($type, $parameters, $resource, $referenced = null)
    {
        return [
            'uuid' => uuid(),
            'type' => $type,
            'parameters' => $parameters,
            'resource' => $resource,
            'user_uuid' => authenticated()->uuid,
            'referenced_uuid' => $referenced,
        ];
    }
}
