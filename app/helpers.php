<?php

use Demency\Contracts\Resource;
use Demency\Relationships\Repositories\ActionsRepository;
use App\Repositories\AdminRepository;
use Demency\Relationships\Repositories\AlertsRepository;
use Demency\Relationships\Repositories\CommentsRepository;
use Demency\Relationships\Repositories\DevicesRepository;
use Demency\Relationships\Repositories\GeofenceAccessesRepository;
use Demency\Relationships\Repositories\LocationsRepository;
use Demency\Relationships\Repositories\PlacesRepository;
use App\Repositories\ReactionsRepository;
use Demency\Relationships\Repositories\ResourceCommentsRepository;
use Demency\Relationships\Repositories\ResourceLocationsRepository;
use Demency\Relationships\Repositories\ResourcePhotosRepository;
use Demency\Relationships\Repositories\ResourceRepository;
use Demency\Relationships\Repositories\UserGroupsRepository;
use Demency\Relationships\Repositories\UsersRepository;
use Demency\Tools\Cataloger;
use Demency\Tools\Filler;
use Demency\Tools\Finder;
use Demency\Tools\Identifier;
use Demency\Tools\Liker;
use Demency\Tools\Measurer;
use Demency\Tools\Parameterizer;
use Demency\Tools\Parser;
use Demency\Tools\Reporter;
use Demency\Tools\Subscriber;
use Demency\Tools\Uploader;
use App\User;
use Demency\Relationships\Repositories\GeofenceRepository;
use Demency\Relationships\Repositories\GroupRepository;
use Demency\Relationships\Repositories\PhotoRepository;
use Demency\Relationships\Repositories\PetRepository;
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

if (! function_exists('pets')) {
    /**
     * @return PetRepository
     */
    function pets()
    {
        return new PetRepository();
    }
}

if (! function_exists('places')) {
    /**
     * @return PlacesRepository
     */
    function places()
    {
        return new PlacesRepository();
    }
}

if (! function_exists('comments')) {
    /**
     * @return CommentsRepository
     */
    function comments()
    {
        return new CommentsRepository();
    }
}

if (! function_exists('resources')) {
    /**
     * @return ResourceRepository
     */
    function resources()
    {
        return new ResourceRepository();
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
     * @return GroupRepository
     */
    function groups()
    {
        return new GroupRepository();
    }
}

if (! function_exists('resourceLocations')) {
    /**
     * @return ResourceLocationsRepository
     */
    function resourceLocations()
    {
        return new ResourceLocationsRepository();
    }
}

if (! function_exists('subscriptions')) {
    /**
     * @return Subscriber
     */
    function subscriptions()
    {
        return new Subscriber();
    }
}

if (! function_exists('resourcePhotos')) {
    /**
     * @return ResourcePhotosRepository
     */
    function resourcePhotos()
    {
        return new ResourcePhotosRepository();
    }
}

if (! function_exists('reactions')) {
    /**
     * @return ReactionsRepository
     */
    function reactions()
    {
        return new ReactionsRepository();
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
     * @return Authenticatable|User
     */
    function authenticated($guard = 'api')
    {
        return auth($guard)->user();
    }
}

if (! function_exists('parameters')) {
    /**
     * @return Parameterizer
     */
    function parameters()
    {
        return new Parameterizer();
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

if (! function_exists('rhas')) {
    /**
     * Check if request has key.
     *
     * @param $key
     * @return bool
     */
    function rhas($key)
    {
        return request()->has($key);
    }
}

if (! function_exists('einput')) {
    /**
     * Extract exploded input.
     *
     * @param $delimiter
     * @param $key
     * @return array
     */
    function einput($delimiter, $key)
    {
        return explode($delimiter, request()->input($key));
    }
}

if (! function_exists('uuid')) {
    /**
     * Get uuid.
     *
     * @return string
     */
    function uuid()
    {
        return Identifier::create();
    }
}

if (! function_exists('likes')) {
    /**
     * Get LikesRepository instance.
     *
     * @return Liker
     */
    function likes()
    {
        return new Liker();
    }
}

if (! function_exists('cataloger')) {
    /**
     * Get Cataloger instance.
     *
     * @return Cataloger
     */
    function cataloger()
    {
        return new Cataloger();
    }
}

if (! function_exists('input')) {
    /**
     * Extract request input.
     *
     * @param $key
     * @return mixed
     */
    function input($key)
    {
        return request()->input($key);
    }
}

if (! function_exists('uploaded')) {
    /**
     * Extract request file.
     *
     * @param $key
     * @return mixed
     */
    function uploaded($key)
    {
        return request()->file($key);
    }
}

if (! function_exists('fill')) {
    function fill($key, $value)
    {
        return Filler::make( $key, $value);
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
     * @return Parser
     */
    function parser()
    {
        return new Parser();
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

if (! function_exists('geofencesAccesses')) {
    /**
     * @return GeofenceAccessesRepository
     */
    function geofencesAccesses()
    {
        return new GeofenceAccessesRepository();
    }
}

if (! function_exists('finder')) {
    /**
     * @return Finder
     */
    function finder() {
        return new Finder();
    }
}

if (! function_exists('admin')) {
    /**
     * @return AdminRepository
     */
    function admin() {
        return new AdminRepository();
    }
}

if (! function_exists('upload')) {
    /**
     * @return Uploader
     */
    function upload() {
        return new Uploader();
    }
}

if (! function_exists('resource')) {
    /**
     * @return Resource
     */
    function resource()
    {
        return (new ResourceRepository())->current();
    }
}

if (! function_exists('userGroups')) {
    /**
     * @return UserGroupsRepository
     */
    function userGroups()
    {
        return new UserGroupsRepository();
    }
}

if (! function_exists('reports')) {
    /**
     * @return Reporter
     */
    function reports()
    {
        return new Reporter();
    }
}

if (! function_exists('measurer')) {
    /**
     * @return Measurer
     */
    function measurer()
    {
        return new Measurer();
    }
}


if (! function_exists('resourceComments')) {
    /**
     * @return ResourceCommentsRepository
     */
    function resourceComments()
    {
        return new ResourceCommentsRepository();
    }
}
