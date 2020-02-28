<?php


namespace App\Repositories;


use App\Device;
use App\Pet;
use App\User;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ModelLocationsRepository
{
    /**
     * Update current model location.
     *
     * @param Request $request
     * @param Model $model
     * @return Model
     */
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
     * Create a device location.
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
                "location" => LocationRepository::parsePoint($data),
                "accuracy" => $data["location"]["coords"]["accuracy"],
                "altitude" => $data["location"]["coords"]["altitude"],
                "speed" => $data["location"]["coords"]["speed"],
                "heading" => $data["location"]["coords"]["heading"],
                "odometer" => $data["location"]["odometer"],
                "event" => LocationRepository::parseEvent($data),
                "activity_type" => $data["location"]["activity"]["type"],
                "activity_confidence" => $data["location"]["activity"]["confidence"],
                "battery_level" => $data["location"]["battery"]["level"],
                "battery_is_charging" => $data["location"]["battery"]["is_charging"],
                "is_moving" => $data["location"]["is_moving"],
                "generated_at" => LocationRepository::parseTimestamp($data),
            ]);
        } else {
            return $model->locations()->create([
                "uuid" => $data["location"]["uuid"],
                "location" => LocationRepository::parsePoint($data),
                "accuracy" => $data["location"]["coords"]["accuracy"],
            ]);
        }
    }

    /**
     * Make filterable locations query.
     *
     * @param $models
     * @param $parameters
     * @return Builder
     * @codeCoverageIgnore
     */
    public static function filterLocations($models, $parameters)
    {
        switch ($parameters['type']) {
            case 'users':
                return static::resolveUserLocations($models, $parameters);
                break;
            case 'pets':
                return static::resolvePetLocations($models, $parameters);
                break;
            default:
                return static::resolveDeviceLocations($models, $parameters);
                break;
        }
    }

    /**
     * Resolve device locations.
     *
     * @param $models
     * @param $parameters
     * @return Builder
     */
    public static function resolveDeviceLocations($models, $parameters)
    {
        return LocationRepository::groupLocationsByUuid(
            LocationRepository::orderLocationsByGeneratedAtDate(
                LocationRepository::filterLocationsUsingRangeOfDates(
                    LocationRepository::filterLocationsByAccuracy(
                        LocationRepository::getDevicesLocationsQuery($models),
                        $parameters['accuracy']
                    ),
                    $parameters['start_date'],
                    $parameters['end_date']
                )
            )
        );
    }

    /**
     * Resolve pet locations.
     *
     * @param $models
     * @param $parameters
     * @return Builder
     */
    public static function resolvePetLocations($models, $parameters)
    {
        return LocationRepository::orderLocationsByCreatedAtDate(
            LocationRepository::filterLocationsUsingCreatedAtRangeOfDates(
                LocationRepository::filterLocationsByAccuracy(
                    LocationRepository::getPetsLocationsQuery(
                        $models
                    ),
                    $parameters['accuracy']
                ),
                $parameters['start_date'],
                $parameters['end_date']
            )
        );
    }

    /**
     * Resolve user locations.
     *
     * @param $models
     * @param $parameters
     * @return Builder
     */
    public static function resolveUserLocations($models, $parameters)
    {
        return LocationRepository::groupLocationsByUuid(
            LocationRepository::orderLocationsByGeneratedAtDate(
                LocationRepository::filterLocationsUsingRangeOfDates(
                    LocationRepository::filterLocationsByAccuracy(
                        LocationRepository::getUsersLocationsQuery(
                            $models
                        ),
                        $parameters['accuracy']
                    ),
                    $parameters['start_date'],
                    $parameters['end_date']
                )
            )
        );
    }
}
