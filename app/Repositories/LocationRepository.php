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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LocationRepository
{
    public static function updateModelLocation(Request $request, Model $model)
    {
        $exploded = explode(',', $request->input('coordinates'));
        $model->update([
            'location' => (new Point(
                floatval($exploded[0]),
                floatval($exploded[1])
            )),
        ]);
        return $model;
    }

    /**
     * Resolve current model for location insert.
     *
     * @param Request $request
     * @return mixed
     */
    public static function resolveLocationModel(Request $request)
    {
        switch ($request->route()->getName()) {
            case 'device.locations':
                return Device::find(auth('devices')->user()->id);
                break;
            case 'pet.locations':
                return Pet::find(auth('pets')->user()->id);
                break;
            default:
                return User::find(auth('api')->user()->id);
                break;
        }
    }

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
        switch ($type) {
            default:
                return Device::whereIn('uuid', $identifiers)->get()->map(function ($device) use ($accuracy) {
                    return static::searchDeviceLocations($device, $accuracy);
                });
            case 'pets':
                return Pet::whereIn('uuid', $identifiers)->get()->map(function ($pet) use ($accuracy) {
                    return static::searchPetsLocations($pet, $accuracy);
                });
                break;
            case 'users':
                return User::whereIn('uuid', $identifiers)->get()->map(function ($user) use ($accuracy) {
                    return static::searchUserLocations($user, $accuracy);
                });
                break;
        }
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
     * Make filterable locations query
     *
     * @param $type
     * @param $models
     * @param $start_date
     * @param $end_date
     * @param $accuracy
     * @return Builder
     * @codeCoverageIgnore
     */
    public static function filterLocations($type, $models, $start_date, $end_date, $accuracy)
    {
        switch ($type) {
            case 'users':
                return self::groupLocationsByUuid(
                    self::orderLocationsByGeneratedAtDate(
                        self::filterLocationsUsingRangeOfDates(
                            self::filterLocationsByAccuracy(
                                self::getUsersLocationsQuery(
                                    $models
                                ),
                                $accuracy
                            ),
                            $start_date,
                            $end_date
                        )
                    )
                );
                break;
            case 'pets':
                return self::orderLocationsByCreatedAtDate(
                    self::filterLocationsUsingCreatedAtRangeOfDates(
                        self::filterLocationsByAccuracy(
                            self::getPetsLocationsQuery(
                                $models
                            ),
                            $accuracy
                        ),
                        $start_date,
                        $end_date
                    )
                );
                break;
            default:
                return static::groupLocationsByUuid(
                    static::orderLocationsByGeneratedAtDate(
                        static::filterLocationsUsingRangeOfDates(
                            static::filterLocationsByAccuracy(
                                static::getDevicesLocationsQuery($models),
                                $accuracy
                            ),
                            $start_date,
                            $end_date
                        )
                    )
                );
                break;
        }
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
     * @param $type
     * @param $devices
     * @param $start_date
     * @param $end_date
     * @param $accuracy
     * @return Collection
     */
    public static function searchLocations($type, $devices, $start_date, $end_date, $accuracy)
    {
        return self::filterLocations($type, $devices, $start_date, $end_date, $accuracy)->get();
    }

    /**
     * Create a device location
     *
     * @param Model $model
     * @param $data
     * @return Model
     */
    public static function createLocation(Model $model, $data)
    {
        if ($model instanceof User || $model instanceof Device) {
            return $model->locations()->create([
                "device" => $data["device"],
                "uuid" => $data["location"]["uuid"],
                "location" => self::parsePoint($data),
                "accuracy" => $data["location"]["coords"]["accuracy"],
                "altitude" => $data["location"]["coords"]["altitude"],
                "speed" => $data["location"]["coords"]["speed"],
                "heading" => $data["location"]["coords"]["heading"],
                "odometer" => $data["location"]["odometer"],
                "event" => self::parseEvent($data),
                "activity_type" => $data["location"]["activity"]["type"],
                "activity_confidence" => $data["location"]["activity"]["confidence"],
                "battery_level" => $data["location"]["battery"]["level"],
                "battery_is_charging" => $data["location"]["battery"]["is_charging"],
                "is_moving" => $data["location"]["is_moving"],
                "generated_at" => self::parseTimestamp($data),
            ]);
        } else {
            return $model->locations()->create([
                "uuid" => $data["location"]["uuid"],
                "location" => self::parsePoint($data),
                "accuracy" => $data["location"]["coords"]["accuracy"],
            ]);
        }
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
        return array_key_exists("event", $data["location"]) ? $data["location"]["event"] : null;
    }
}
