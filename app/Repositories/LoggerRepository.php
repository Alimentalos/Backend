<?php

namespace App\Repositories;

use App\Action;

class LoggerRepository
{
    /**
     * Create non referenced action.
     *
     * @param $user
     * @param $type
     * @param $resource
     * @param $parameters
     * @return mixed
     */
    public static function createAction($user, $type, $resource, $parameters)
    {
        return Action::create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'type' => $type,
            'parameters' => $parameters,
            'resource' => $resource,
            'user_id' => $user->id,
            'referenced_id' => null,
        ]);
    }

    /**
     * Create referenced action.
     *
     * @param $user
     * @param $parameters
     * @return mixed
     */
    public static function createReferencedAction($user, $parameters)
    {
        return Action::create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'type' => $parameters['type'],
            'parameters' => $parameters['parameters'],
            'resource' => $parameters['resource'],
            'user_id' => $user->id,
            'referenced_id' => $parameters['referenced']
        ]);
    }
}
