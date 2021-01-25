<?php

namespace Alimentalos\Relationships\Queries;

use App\Models\Location;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
use Illuminate\Support\Collection;

trait LocationQuery
{
    /**
     * Scope query using group by uuid.
     *
     * @param Builder $locations
     * @param string $column
     * @return Builder
     */
    public function groupByColumn(Builder $locations, $column = 'uuid')
    {
        return $locations->groupBy($column);
    }

    /**
     * Scope query using order by column.
     *
     * @param Builder $query
     * @param $column
     * @param string $order
     * @return Builder
     */
    public function orderByColumn(Builder $query, $column, $order = 'desc')
    {
        return $query->orderBy($column, $order);
    }

    /**
     * Scope query using range of dates.
     *
     * @param Builder $query
     * @param $parameters
     * @param string $order
     * @return Builder
     */
    public function queryRangeOfDates(Builder $query, $parameters, $order = 'desc')
    {
        return $query->whereBetween($parameters['column'], [
            Carbon::parse($parameters['start_date']),
            Carbon::parse($parameters['end_date'])
        ])->orderBy($parameters['column'], $order);
    }

    /**
     * Scope query using max accuracy value.
     *
     * @param $locations
     * @param $accuracy
     * @return Builder
     */
    public function maxAccuracy(Builder $locations, $accuracy)
    {
        return $locations->where('accuracy', '<=', $accuracy);
    }

    /**
     * Get devices locations query
     *
     * @param Collection $devices
     * @param string $type
     * @return Builder
     */
    public function trackableQuery(Collection $devices, $type = 'App\\Pet')
    {
        return Location::whereIn(
            'trackable_id',
            array_column($devices->toArray(), 'uuid')
        )->where('trackable_type', $type);
    }
}
