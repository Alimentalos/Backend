<?php

namespace Alimentalos\Tools\Reports\Types;

use Alimentalos\Relationships\Models\Device;
use App\Http\Resources\Location;
use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;

class Type
{

    /**
     * Comma separated devices
     *
     * @var array
     */
    protected $devices;

    /**
     * Start date
     *
     * @var string
     */
    protected $start_date;

    /**
     * Start day
     *
     * @var string
     */
    protected $start_day;

    /**
     * End date
     *
     * @var string
     */
    protected $end_date;

    /**
     * End day
     *
     * @var string
     */
    protected $end_day;

    /**
     * Parameters
     *
     * @var array
     */
    protected $parameters;

    /**
     * Reports
     *
     * @var array
     */
    protected $reports;

    /**
     * Type constructor.
     */
    public function __construct()
    {
        $this->reports = [];
    }

    /**
     * Settings parameters
     *
     * @param $devices
     * @param $start_date
     * @param $end_date
     * @param $parameters
     */
    public function setParameters($devices, $start_date, $end_date, $parameters)
    {
        $this->devices = devices()->fetchInDatabase($devices)->get();
        $this->start_date = $start_date;
        $this->start_day = explode(" ", $start_date)[0];
        $this->end_date = $end_date;
        $this->end_day = explode(" ", $end_date)[0];
        $this->parameters = $parameters;
    }

    /**
     * Get filterable query
     *
     * @return Builder
     */
    public function getFilterableQuery()
    {
        return resourceLocations()->filterLocations( // Search locations
            $this->devices, // of those devices
            [
                'type' => 'devices',
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'accuracy' => $this->parameters['accuracy']
            ]
        );
    }

    /**
     * Generate device summary
     *
     * @param Device $device
     * @return array
     */
    public function generateDeviceSummary(Device $device)
    {
        return [
            "uuid" => $device->uuid,
            "name" => $device->name,
            "description" => $device->description,
        ];
    }

    /**
     * Generate device report using data
     *
     * @param $device
     * @param $data
     * @return array
     */
    public function generateReport($device, $data)
    {
        return [
            "device" => $this->generateDeviceSummary($device),
            "data" => $data
        ];
    }

    /**
     * Generate empty summary by day
     *
     * @param $day
     * @return array
     */
    public function generateEmptySummary(Carbon $day)
    {
        return [
            "summary" => [
                "status" => 404,
                "from" => $day->format('Y-m-d 00:00:00'),
                "to" => $day->format('Y-m-d 23:59:59')
            ]
        ];
    }

    /**
     * Generate point details
     *
     * @param $point
     * @return array
     */
    public function generatePointSummary(Location $point)
    {
        return [
            "time" => $point->generated_at->format('Y-m-d H:i:s'),
            "latitude" => $point->location->getLat(),
            "longitude" => $point->location->getLng(),
            "altitude" => $point->altitude,
            "street" => $this->generateStreet($point->location->getLat(), $point->location->getLng()),
        ];
    }

    /**
     * Generate street based on latitude and longitude
     *
     * @param $latitude
     * @param $longitude
     * @return string
     */
    public function generateStreet($latitude, $longitude)
    {
        return "$latitude,$longitude";
    }
}
