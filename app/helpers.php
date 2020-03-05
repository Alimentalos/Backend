<?php

use App\Contracts\Resource;
use App\Repositories\ActionsRepository;
use App\Repositories\AlertsRepository;
use App\Repositories\DevicesRepository;
use App\Repositories\FillRepository;
use App\Repositories\FinderRepository;
use App\Repositories\GeofenceRepository;
use App\Repositories\GroupsRepository;
use App\Repositories\LocationsRepository;
use App\Repositories\ModelLocationsRepository;
use App\Repositories\ParserRepository;
use App\Repositories\ParametersRepository;
use App\Repositories\PhotoRepository;
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

if (! function_exists('photos')) {
    /**
     * @return PhotoRepository
     */
    function photos()
    {
        return new PhotoRepository();
    }
}

if (! function_exists('locations')) {
    /**
     * @return LocationsRepository
     */
    function locations()
    {
        return new LocationsRepository();
    }
}

if (! function_exists('input')) {
    function input($key)
    {
        return request()->input($key);
    }
}

if (! function_exists('fill')) {
    function fill($key, $value)
    {
        return FillRepository::fillAttribute( $key, $value);
    }
}

if (! function_exists('only')) {
    function only($keys)
    {
        return request()->only(func_get_args());
    }
}

if (! function_exists('parser')) {
    /**
     * @return ParserRepository
     */
    function parser()
    {
        return new ParserRepository();
    }
}

if (! function_exists('devices')) {
    /**
     * @return DevicesRepository
     */
    function devices()
    {
        return new DevicesRepository();
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

if (! function_exists('modelLocations')) {
    /**
     * @return ModelLocationsRepository
     */
    function modelLocations()
    {
        return new ModelLocationsRepository();
    }
}
