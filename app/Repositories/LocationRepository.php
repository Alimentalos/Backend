<?php

namespace App\Repositories;

use App\Location;
use App\Parsers\LocationParser;
use App\Queries\LocationQuery;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
use Illuminate\Support\Collection;

class LocationRepository
{
    use LocationQuery;
    use LocationParser;

    public const LATITUDE = 0;


    public const LONGITUDE = 1;

    /**
     * Search last devices locations.
     *
     * @param $type
     * @param $identifiers
     * @param $accuracy
     * @return Collection
     */
    public static function searchLastLocations($type, $identifiers, $accuracy)
    {
        return HandleBindingRepository::bindResourceModel($type)->whereIn('uuid', $identifiers)->get()->map(function ($model) use ($accuracy) {
            return $model->searchLocations($accuracy);
        });
    }

    /**
     * Search in user locations
     *
     * @param $user
     * @param $accuracy
     * @return Builder
     */
    public static function searchUserLocations($user, $accuracy)
    {
        return static::orderByColumn(
            static::maxAccuracy(static::trackableQuery(collect([$user]), 'App\\User'), $accuracy),
            'generated_at'
        )->first();
    }

    /**
     * Search in pet locations
     *
     * @param $pet
     * @param $accuracy
     * @return Builder
     */
    public static function searchPetsLocations($pet, $accuracy)
    {
        return static::orderByColumn(
            static::maxAccuracy(static::trackableQuery(collect([$pet]), 'App\\Pet'), $accuracy),
            'created_at'
        )->first();
    }

    /**
     * Search in device locations
     *
     * @param $device
     * @param $accuracy
     * @return Builder
     */
    public static function searchDeviceLocations($device, $accuracy)
    {
        return static::orderByColumn(
            static::maxAccuracy(static::trackableQuery(collect([$device]), 'App\\Device'), $accuracy),
            'generated_at'
        )->first();
    }

    /**
     * Search devices locations between two dates
     *
     * @param $devices
     * @param $parameters
     * @return Collection
     */
    public static function searchLocations($devices, $parameters)
    {
        return ModelLocationsRepository::filterLocations($devices, $parameters)->get();
    }
}
