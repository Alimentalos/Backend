<?php

use App\Contracts\Resource;
use App\Repositories\ActionsRepository;
use App\Repositories\AdminRepository;
use App\Repositories\AlertsRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\DevicesRepository;
use App\Repositories\FillRepository;
use App\Repositories\FinderRepository;
use App\Repositories\GeofenceAccessesRepository;
use App\Repositories\GeofenceRepository;
use App\Repositories\GroupsRepository;
use App\Repositories\LikeRepository;
use App\Repositories\LocationsRepository;
use App\Repositories\ModelLocationsRepository;
use App\Repositories\ParametersRepository;
use App\Repositories\ParserRepository;
use App\Repositories\PetsRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\ReactionsRepository;
use App\Repositories\ReportsRepository;
use App\Repositories\ResourceCommentsRepository;
use App\Repositories\ResourceLocationsRepository;
use App\Repositories\ResourcePhotosRepository;
use App\Repositories\ResourceRepository;
use App\Repositories\StatusRepository;
use App\Repositories\SubscriptionsRepository;
use App\Repositories\TokenRepository;
use App\Repositories\UniqueNameRepository;
use App\Repositories\UploadRepository;
use App\Repositories\UserGroupsRepository;
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

if (! function_exists('pets')) {
    /**
     * @return PetsRepository
     */
    function pets()
    {
        return new PetsRepository();
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
     * @return GroupsRepository
     */
    function groups()
    {
        return new GroupsRepository();
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
     * @return SubscriptionsRepository
     */
    function subscriptions()
    {
        return new SubscriptionsRepository();
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

if (! function_exists('token')) {
    /**
     * @return TokenRepository
     */
    function token()
    {
        return new TokenRepository();
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

if (! function_exists('status')) {
    /**
     * @return StatusRepository
     */
    function status()
    {
        return new StatusRepository();
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
        return UniqueNameRepository::createIdentifier();
    }
}

if (! function_exists('likes')) {
    /**
     * Get LikesRepository instance.
     *
     * @return LikeRepository
     */
    function likes()
    {
        return new LikeRepository();
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
     * @return FinderRepository
     */
    function finder() {
        return new FinderRepository();
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
     * @return UploadRepository
     */
    function upload() {
        return new UploadRepository();
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
     * @return ReportsRepository
     */
    function reports()
    {
        return new ReportsRepository();
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

if (! function_exists('modelLocations')) {
    /**
     * @return ModelLocationsRepository
     */
    function modelLocations()
    {
        return new ModelLocationsRepository();
    }
}
