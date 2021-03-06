<?php


namespace Alimentalos\Tools\Procedures;


use Alimentalos\Tools\Reports\Report;

trait ReportProcedure
{
    /**
     * Available reports
     *
     * @var array
     */
    protected $availableReports = [
        'activity' => [
            'parameters' => [],
        ],
        'speed' => [
            'parameters' => ['min', 'max']
        ],
    ];

    /**
     * Default parameters
     *
     * @var array
     */
    protected $defaultRequiredParameters = [
        'type',
        'accuracy'
    ];

    /**
     * Retrieve.
     *
     * @param $devices
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public function retrieve($devices, $start_date, $end_date)
    {
        if ($devices == '') { $devices = devices()->fetchInDatabase($devices)->get(); }
        return (new Report($devices, $start_date, $end_date, $this->retrieveParameters()))->fetchData();
    }

    /**
     * Retrieve parameters from request.
     *
     * @return array
     */
    public function retrieveParameters()
    {
        return request()->only(
            $this->retrieveRequiredParameters(
                fill( 'type', static::DEFAULT_TYPE)
            )
        );
    }

    /**
     * Retrieve required parameters.
     *
     * @param $type
     * @return array
     */
    public function retrieveRequiredParameters($type)
    {
        return array_merge($this->defaultRequiredParameters, $this->availableReports[$type]['parameters']);
    }
}
