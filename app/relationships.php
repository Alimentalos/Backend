<?php

use App\Contracts\Resource;
use Alimentalos\Relationships\Repositories\{ActionsRepository,
	AlertsRepository,
	CommentsRepository,
	DevicesRepository,
	GeofenceAccessesRepository,
	GeofencesRepository,
	GroupsRepository,
	LocationsRepository,
	PetsRepository,
	PhotosRepository,
	PlacesRepository,
	ReactionsRepository,
	ResourceCommentsRepository,
	ResourceLocationsRepository,
	ResourcePhotosRepository,
	ResourceRepository,
	UserGroupsRepository,
	UsersRepository};

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
     * @return GeofencesRepository
     */
    function geofences()
    {
        return new GeofencesRepository();
    }
}
if (! function_exists('photos')) {
    /**
     * @return PhotosRepository
     */
    function photos()
    {
        return new PhotosRepository();
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
if (! function_exists('resourceComments')) {
    /**
     * @return ResourceCommentsRepository
     */
    function resourceComments()
    {
        return new ResourceCommentsRepository();
    }
}
