<?php


namespace App\Repositories;


use App\Device;
use App\Pet;
use App\Queries\LocationQuery;
use App\User;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ModelLocationsRepository
{
    use LocationQuery;

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
            'location' => LocationsRepository::parsePointFromCoordinates($request->input('coordinates')),
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
                return Device::where('uuid', auth('devices')->user()->uuid)->firstOrFail();
                break;
            case 'pet':
                return Pet::where('uuid', auth('pets')->user()->uuid)->firstOrFail();
                break;
            default:
                return User::where('uuid', auth('api')->user()->uuid)->firstOrFail();
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
                "location" => LocationsRepository::parsePoint($data),
                "accuracy" => $data["location"]["coords"]["accuracy"],
                "altitude" => $data["location"]["coords"]["altitude"],
                "speed" => $data["location"]["coords"]["speed"],
                "heading" => $data["location"]["coords"]["heading"],
                "odometer" => $data["location"]["odometer"],
                "event" => LocationsRepository::parseEvent($data),
                "activity_type" => $data["location"]["activity"]["type"],
                "activity_confidence" => $data["location"]["activity"]["confidence"],
                "battery_level" => $data["location"]["battery"]["level"],
                "battery_is_charging" => $data["location"]["battery"]["is_charging"],
                "is_moving" => $data["location"]["is_moving"],
                "generated_at" => LocationsRepository::parseTimestamp($data),
            ]);
        } else {
            return $model->locations()->create([
                "uuid" => $data["location"]["uuid"],
                "location" => LocationsRepository::parsePoint($data),
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
        $class = binder()::bindResourceModelClass($parameters['type']);
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
        return static::groupByColumn(
            static::orderByColumn(
                static::queryRangeOfDates(
                    static::maxAccuracy(static::trackableQuery($models, $type), $parameters['accuracy']),
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
