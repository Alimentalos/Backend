<?php

namespace App\Repositories;

use App\Parsers\LocationParser;
use App\Queries\LocationQuery;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
use Illuminate\Support\Collection;

class LocationsRepository
{
    use LocationQuery;
    use LocationParser;

    /**
     * Longitude position.
     */
    public const LATITUDE = 0;

    /**
     * Latitude position.
     */
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
        return binder()::bindResourceModel($type)->whereIn('uuid', $identifiers)->get()->map(function ($model) use ($accuracy) {
            return static::searchModelLocations($model, $accuracy);
        });
    }

    /**
     * Search model locations.
     *
     * @param $model
     * @param $accuracy
     * @return Builder
     */
    public static function searchModelLocations($model, $accuracy)
    {
        $class = get_class($model);
        return static::orderByColumn(
            static::maxAccuracy(static::trackableQuery(collect([$model]), $class), $accuracy),
            $class::DEFAULT_LOCATION_DATE_COLUMN
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
