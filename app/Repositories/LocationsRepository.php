<?php

namespace App\Repositories;

use App\Http\Resources\LocationCollection;
use App\Parsers\LocationParser;
use App\Queries\LocationQuery;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
use Illuminate\Http\Request;
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
     * Fetch last locations via request.
     *
     * @return LocationCollection
     */
    public function fetchLastLocationsViaRequest()
    {
        $locations = $this->searchLastLocations(
            request()->input('type'), request()->input('identifiers'), request()->input('accuracy')
        );

        return new LocationCollection(
            $locations->filter(fn($location) => !is_null($location))
        );
    }

    /**
     * Fetch locations via request.
     *
     * @return Collection
     */
    public function fetchViaRequest()
    {
        $class = finder()
            ->findClass(request()->input('type'));

        $models= $class::whereIn(
            'uuid', explode(',', request()->input('identifiers'))
        )->get();

        return $this->searchLocations($models, request()->only('type', 'start_date', 'end_date', 'accuracy'));
    }

    /**
     * Search last devices locations.
     *
     * @param $type
     * @param $identifiers
     * @param $accuracy
     * @return Collection
     */
    public function searchLastLocations($type, $identifiers, $accuracy)
    {
        return finder()
            ->findModel($type)
            ->whereIn('uuid', $identifiers)
            ->get()
            ->map(fn($model) => $this->searchModelLocations($model, $accuracy));
    }

    /**
     * Search model locations.
     *
     * @param $model
     * @param $accuracy
     * @return Builder
     */
    public function searchModelLocations($model, $accuracy)
    {
        $class = get_class($model);
        return $this->orderByColumn(
            $this->maxAccuracy(
                $this->trackableQuery(collect([$model]), $class),
                $accuracy
            ),
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
    public function searchLocations($devices, $parameters)
    {
        return ModelLocationsRepository::filterLocations($devices, $parameters)->get();
    }
}
