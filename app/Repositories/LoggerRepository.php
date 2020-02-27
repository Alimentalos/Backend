<?php

namespace App\Repositories;

use App\Action;

class LoggerRepository
{
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

    public static function createReferencedAction($user, $type, $resource, $parameters, $referenced)
    {
        return Action::create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'type' => $type,
            'parameters' => $parameters,
            'resource' => $resource,
            'user_id' => $user->id,
            'referenced_id' => $referenced
        ]);
    }
}
