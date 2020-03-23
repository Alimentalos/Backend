<?php


namespace Demency\Relationships\Procedures;

use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;

trait ResourceLocationProcedure
{
    /**
     * Make filterable locations query.
     *
     * @param $models
     * @param $parameters
     * @return Builder
     */
    public function filterLocations($models, $parameters)
    {
        $class = finder()->findClass($parameters['type']);
        return $this->resolveLocations(
            $models,
            $parameters,
            [
                'type' => get_class($class),
                'dateColumn' => $class::DEFAULT_LOCATION_DATE_COLUMN,
                'groupedBy' => $class::DEFAULT_LOCATION_GROUP_BY_COLUMN
            ]
        );
    }

    /**
     * Resolve model locations.
     *
     * @param $models
     * @param $parameters
     * @param $filters
     * @return Builder
     */
    public function resolveLocations($models, $parameters, $filters)
    {
        return $this->groupByColumn(
            $this->orderByColumn(
                $this->queryRangeOfDates(
                    $this->maxAccuracy(
                        $this->trackableQuery(
                            $models,
                            $filters['type']
                        ),
                        $parameters['accuracy']
                    ),
                    [
                        'start_date' => $parameters['start_date'],
                        'end_date' => $parameters['end_date'],
                        'column' => $filters['dateColumn']
                    ]
                ),
                $filters['dateColumn']
            ),
            $filters['groupedBy']
        );
    }
}
