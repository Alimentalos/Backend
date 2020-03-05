<?php

namespace App\Repositories;

use App\Reports\Report;

class ReportsRepository
{
    /**
     * Default report type
     *
     * @var string
     */
    public const DEFAULT_TYPE = 'activity';

    /**
     * Available reports
     *
     * @var array
     */
    protected array $availableReports = [
        'activity' => [
            'parameters' => [],
        ],
        'speed' => [
            'parameters' => ['min', 'max']
        ],
    ];

    /**
     * Default required parameters
     *
     * @var array
     */
    protected array $defaultParameters = [
        'type',
        'accuracy'
    ];

    public function fetchViaRequest()
    {
        return $this->generateData(
            input('devices'),
            input('start_date'),
            input('end_date'),
            request()->only(
                $this->requiredParameters(
                    fill( 'type', static::DEFAULT_TYPE)
                )
            )
        );
    }

    /**
     * Generate report data
     *
     * @param $devices
     * @param $start_date
     * @param $end_date
     * @param $parameters
     * @return array
     */
    public function generateData($devices, $start_date, $end_date, $parameters)
    {
        if ($devices == '') { $devices = devices()->fetchInDatabase($devices); }
        return (new Report($devices, $start_date, $end_date, $parameters))->fetchData();
    }

    /**
     * Get required parameters
     *
     * @param $type
     * @return array
     */
    public function requiredParameters($type)
    {
        return array_merge($this->defaultParameters, $this->availableReports[$type]['parameters']);
    }
}
