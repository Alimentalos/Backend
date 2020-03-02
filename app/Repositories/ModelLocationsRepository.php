<?php


namespace App\Repositories;


use App\Device;
use App\Pet;
use App\User;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
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
        $model->update([
            'location' => LocationRepository::parsePointFromCoordinates($request->input('coordinates')),
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
        $resource = explode('.', $request->route()->getName())[0];
        switch ($resource) {
            case 'device':
                return Device::find(auth('devices')->user()->id);
                break;
            case 'pet':
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
        $class = HandleBindingRepository::bindResourceModelClass($parameters['type']);
        return static::resolveLocations($models, $parameters, get_class($class), $class::DEFAULT_LOCATION_DATE_COLUMN, $class::DEFAULT_LOCATION_GROUP_BY_COLUMN);
    }

    /**
     * Resolve model locations.
     *
     * @param $models
     * @param $parameters
     * @param $type
     * @param $dateColumn
     * @param $groupedBy
     * @return Builder
     */
    public static function resolveLocations($models, $parameters, $type, $dateColumn, $groupedBy)
    {
        return LocationRepository::groupByColumn(
            LocationRepository::orderByColumn(
                LocationRepository::queryRangeOfDates(
                    LocationRepository::maxAccuracy(
                        LocationRepository::trackableQuery(
                            $models,
                            $type
                        ),
                        $parameters['accuracy']
                    ),
                    $parameters['start_date'],
                    $parameters['end_date'],
                    $dateColumn
                ),
                $dateColumn
            ),
            $groupedBy
        );
    }
}
