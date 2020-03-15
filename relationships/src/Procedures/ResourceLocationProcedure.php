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
            get_class($class),
            $class::DEFAULT_LOCATION_DATE_COLUMN,
            $class::DEFAULT_LOCATION_GROUP_BY_COLUMN
        );
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
    public function resolveLocations($models, $parameters, $type, $dateColumn, $groupedBy)
    {
        return $this->groupByColumn(
            $this->orderByColumn(
                $this->queryRangeOfDates(
                    $this->maxAccuracy(
                        $this->trackableQuery(
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
