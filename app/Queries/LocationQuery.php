<?php

namespace App\Queries;

use App\Location;
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
    public static function groupByColumn(Builder $locations, $column = 'uuid')
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
    public static function orderByColumn(Builder $query, $column, $order = 'desc')
    {
        return $query->orderBy($column, $order);
    }

    /**
     * Scope query using range of dates.
     *
     * @param Builder $query
     * @param $start_date
     * @param $end_date
     * @param $column
     * @param string $order
     * @return Builder
     */
    public static function queryRangeOfDates(Builder $query, $start_date, $end_date, $column, $order = 'desc')
    {
        return $query->whereBetween($column, [
            Carbon::parse($start_date),
            Carbon::parse($end_date)
        ])->orderBy($column, $order);
    }

    /**
     * Scope query using max accuracy value.
     *
     * @param $locations
     * @param $accuracy
     * @return Builder
     */
    public static function maxAccuracy(Builder $locations, $accuracy)
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
    public static function trackableQuery(Collection $devices, $type = 'App\\Pet')
    {
        return Location::whereIn(
            'trackable_id',
            array_column($devices->toArray(), 'id')
        )->where('trackable_type', $type);
    }
}
