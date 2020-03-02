<?php

namespace App\Repositories;

use App\Device;
use App\Location;
use App\Pet;
use App\PetLocation;
use App\User;
use App\UserLocation;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Collection;

class LocationRepository
{
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
     * @codeCoverageIgnore
     */
    public static function searchUserLocations($user, $accuracy)
    {
        return static::orderLocationsByGeneratedAtDate(
            static::filterLocationsByAccuracy(
                static::getUsersLocationsQuery(
                    collect(
                        [ $user ]
                    )
                ),
                $accuracy
            )
        )->first();
    }

    /**
     * Search in pet locations
     *
     * @param $pet
     * @param $accuracy
     * @return Builder
     * @codeCoverageIgnore
     */
    public static function searchPetsLocations($pet, $accuracy)
    {
        return static::orderLocationsByCreatedAtDate(
            static::filterLocationsByAccuracy(
                static::getPetsLocationsQuery(
                    collect(
                        [ $pet ]
                    )
                ),
                $accuracy
            )
        )->first();
    }

    /**
     * Search in device locations
     *
     * @param $device
     * @param $accuracy
     * @return Builder
     * @codeCoverageIgnore
     */
    public static function searchDeviceLocations($device, $accuracy)
    {
        return static::orderLocationsByGeneratedAtDate(
            static::filterLocationsByAccuracy(
                static::getDevicesLocationsQuery(
                    collect(
                        [ $device ]
                    )
                ),
                $accuracy
            )
        )->first();
    }

    /**
     * Group locations query by uuid
     *
     * @param $locations
     * @return Builder
     */
    public static function groupLocationsByUuid(Builder $locations)
    {
        return $locations->groupBy('uuid');
    }

    /**
     * Order locations query by generated at using descendant direction
     *
     * @param $locations
     * @return Builder
     */
    public static function orderLocationsByGeneratedAtDate(Builder $locations)
    {
        return $locations->orderBy('generated_at', 'desc');
    }

    /**
     * Order locations query by created at using descendant direction
     *
     * @param $locations
     * @return Builder
     */
    public static function orderLocationsByCreatedAtDate(Builder $locations)
    {
        return $locations->orderBy('created_at', 'desc');
    }

    /**
     * Get devices locations query
     *
     * @param $devices
     * @return Builder
     */
    public static function getDevicesLocationsQuery(Collection $devices)
    {
        return Location::whereIn(
            'trackable_id',
            array_column($devices->toArray(), 'id')
        )->where('trackable_type', 'App\\Device');
    }

    /**
     * Get users locations query
     *
     * @param Collection $users
     * @return Builder
     */
    public static function getUsersLocationsQuery(Collection $users)
    {
        return Location::whereIn(
            'trackable_id',
            array_column($users->toArray(), 'id')
        )->where('trackable_type', 'App\\User');
    }

    /**
     * Get pets locations query
     *
     * @param Collection $pets
     * @return Builder
     */
    public static function getPetsLocationsQuery(Collection $pets)
    {
        return Location::whereIn(
            'trackable_id',
            array_column($pets->toArray(), 'id')
        )->where('trackable_type', 'App\\Pet');
    }

    /**
     * Filter location query using a range of dates
     *
     * @param $locations
     * @param $start_date
     * @param $end_date
     * @return Builder
     */
    public static function filterLocationsUsingRangeOfDates(Builder $locations, $start_date, $end_date)
    {
        return $locations->whereBetween('generated_at', [
            Carbon::parse($start_date),
            Carbon::parse($end_date)
        ])->orderBy('generated_at', 'desc');
    }

    /**
     * Filter location query using a range of dates
     *
     * @param $locations
     * @param $start_date
     * @param $end_date
     * @return Builder
     */
    public static function filterLocationsUsingCreatedAtRangeOfDates(Builder $locations, $start_date, $end_date)
    {
        return $locations->whereBetween('created_at', [
            Carbon::parse($start_date),
            Carbon::parse($end_date)
        ])->orderBy('created_at', 'desc');
    }

    /**
     * Filter location query using accuracy parameter
     *
     * @param $locations
     * @param $accuracy
     * @return Builder
     */
    public static function filterLocationsByAccuracy(Builder $locations, $accuracy)
    {
        return $locations->where('accuracy', '<=', $accuracy);
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

    /**
     * Parse data latitude and longitude to Spatial Point type
     *
     * @param $data
     * @return Point
     */
    public static function parsePoint($data)
    {
        return new Point(
            $data["location"]["coords"]["latitude"],
            $data["location"]["coords"]["longitude"]
        );
    }

    /**
     * Parse data timestamp adding the timezone offset
     *
     * @param $data
     * @return Carbon
     */
    public static function parseTimestamp($data)
    {
        return Carbon::parse($data["location"]["timestamp"])
            ->subHours(3);
    }

    /**
     * Parse data event type
     *
     * @param $data
     * @return string|null
     */
    public static function parseEvent($data)
    {
        return array_key_exists("event", $data["location"]) ? $data["location"]["event"] : 'default';
    }
}
