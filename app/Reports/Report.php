<?php

namespace App\Reports;

use App\Reports\Types\Activity;
use App\Reports\Types\Speed;
use App\Reports\Types\Type;

class Report
{

    /**
     * Comma separated devices
     *
     * @var string
     */
    protected $devices;

    /**
     * Start date
     *
     * @var string
     */
    protected $start_date;

    /**
     * End date
     *
     * @var string
     */
    protected $end_date;

    /**
     * Parameters
     *
     * @var array
     */
    protected $parameters;

    /**
     * Typed report
     * @var Type
     */
    protected $report;

    /**
     * Report constructor.
     *
     * @param $devices
     * @param $start_date
     * @param $end_date
     * @param $parameters
     */
    public function __construct($devices, $start_date, $end_date, $parameters)
    {
        $this->devices = $devices;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->parameters = $parameters;

        switch ($parameters['type']) {
            case 'speed':
                $this->report = new Speed();
                break;
            case 'activity':
                $this->report = new Activity();
                break;
        }
    }

    /**
     * Fetch report data.
     *
     * @return array
     */
    public function fetchData()
    {
        $this->report->setParameters(
            $this->devices,
            $this->start_date,
            $this->end_date,
            $this->parameters
        );
        return $this->report->toArray();
    }
}
