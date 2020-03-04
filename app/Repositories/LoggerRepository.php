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
        return Action::create(static::buildCreateParameters($type, $parameters, $resource, $user));
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
        return Action::create(static::buildCreateParameters($parameters['type'], $parameters['parameters'], $parameters['resource'], $user, $parameters['referenced']));
    }

    /**
     * Create parameters for action create.
     *
     * @param $type
     * @param $parameters
     * @param $resource
     * @param $user
     * @param null $referenced
     * @return array
     */
    public static function buildCreateParameters($type, $parameters, $resource, $user, $referenced = null)
    {
        return [
            'uuid' => UniqueNameRepository::createIdentifier(),
            'type' => $type,
            'parameters' => $parameters,
            'resource' => $resource,
            'user_uuid' => $user->uuid,
            'referenced_uuid' => $referenced,
        ];
    }
}
