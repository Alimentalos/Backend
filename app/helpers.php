<?php

use App\Contracts\Resource;
use App\Repositories\ActionsRepository;
use App\Repositories\AlertsRepository;
use App\Repositories\FinderRepository;
use App\Repositories\GeofenceRepository;
use App\Repositories\GroupsRepository;
use App\Repositories\ParametersRepository;
use App\Repositories\ResourceRepository;
use App\Repositories\UsersRepository;
use Illuminate\Contracts\Auth\Authenticatable;

if (! function_exists('actions')) {
    /**
     * @return ActionsRepository
     */
    function actions()
    {
        return new ActionsRepository();
    }
}

if (! function_exists('alerts')) {
    /**
     * @return AlertsRepository
     */
    function alerts()
    {
        return new AlertsRepository();
    }
}

if (! function_exists('groups')) {
    /**
     * @return GroupsRepository
     */
    function groups()
    {
        return new GroupsRepository();
    }
}

if (! function_exists('geofences')) {
    /**
     * @return GeofenceRepository
     */
    function geofences()
    {
        return new GeofenceRepository();
    }
}

if (! function_exists('authenticated')) {
    /**
     * @param string $guard
     * @return Authenticatable
     */
    function authenticated($guard = 'api')
    {
        return auth($guard)->user();
    }
}

if (! function_exists('parameters')) {
    /**
     * @return ParametersRepository
     */
    function parameters()
    {
        return new ParametersRepository();
    }
}

if (! function_exists('users')) {
    /**
     * @return UsersRepository
     */
    function users()
    {
        return new UsersRepository();
    }
}

if (! function_exists('finder')) {
    /**
     * @return FinderRepository
     */
    function finder() {
        return new FinderRepository();
    }
}

if (! function_exists('resource')) {
    /**
     * @return Resource
     */
    function resource()
    {
        return (new ResourceRepository())->currentResource();
    }
}
