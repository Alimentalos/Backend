<?php

namespace App\Reports\Types;

use App\Http\Resources\Location;
use App\Http\Resources\LocationCollection;
use App\Reports\Helpers\RangesHelper;
use Carbon\Carbon;

class Activity extends Type
{
    /**
     * Current location and index.
     *
     * @var mixed
     */
    protected $current;

    /**
     * Current loop parameters.
     *
     * @var mixed
     */
    protected $currentParameters;

    /**
     * Detected ranges.
     *
     * @var mixed
     */
    protected $ranges;

    /**
     * Get Activity report as Array.
     *
     * @return array
     */
    public function toArray()
    {
        // Fetch locations
        $locations = $this->getFilterableQuery()
            ->get();

        // For every device
        foreach ($this->devices as $device) {
            $this->perDevice($device, $locations);
        }
        return $this->reports;
    }

    /**
     * Per device report.
     *
     * @param $device
     * @param $locations
     */
    public function perDevice($device, $locations)
    {
        // Filter the specified device locations
        $device_locations = $locations->where('trackable_id', $device->uuid)
            ->where('trackable_type', 'App\\Device')->reverse()->values();

        if ($this->start_day == $this->end_day) {
            $this->simpleReport($device, $device_locations);
        } else {
            $this->composedReport($device, $device_locations);
        }
    }

    /**
     * Generate composed report.
     *
     * @param $device
     * @param $device_locations
     */
    public function composedReport($device, $device_locations)
    {
        $data = [];

        // Define start date
        $start_date = Carbon::parse("$this->start_day 00:00:00");
        $end_date = Carbon::parse("$this->end_day 00:00:00");

        // For every day required
        for ($offset = 0; $offset <= $start_date->diffInDays($end_date); $offset++) {
            // Define current day
            $current_day = Carbon::parse("$this->start_day 00:00:00")->addDays($offset);

            // Filter per day locations from device locations
            $per_day_locations = $device_locations->whereBetween("generated_at", [
                $current_day->format("Y-m-d 00:00:00"),
                $current_day->format("Y-m-d 23:59:59"),

            ]);

            // Push the per day report into data array
            $data[] = $this->generateReportPerDay($per_day_locations, $current_day);
        }

        // Push the required report into reports array
        $this->reports[] = $this->generateReport($device, $data);
    }

    /**
     * Generate simple report.
     *
     * @param $device
     * @param $device_locations
     */
    public function simpleReport($device, $device_locations)
    {
        $data = [];

        // Push the per day report into data array
        $data[] = $this->generateReportPerDay($device_locations, Carbon::parse($this->start_date));

        // Push the required report into reports array
        $this->reports[] = $this->generateReport($device, $data);
    }

    /**
     * Generate ranges using collection of locations.
     *
     * @param $locations
     * @return array
     */
    public function generateRanges($locations)
    {
        $this->ranges = [];
        $this->currentParameters = [
            'moving' => false,
            'start_position' => null,
            'end_position' => null,
        ];

        foreach ($locations as $index => $location) {
            $this->current = [
                'location' => $location,
                'index' => $index,
            ];

            $this->perLocation($locations);
        }

        return $this->ranges;
    }

    /**
     * Per location loop callback.
     *
     * @param $locations
     */
    public function perLocation($locations)
    {
        $this->checkStoppedIsNowMoving();
        $this->checkMovingIsNowStopped();
        $this->checkAndCreateRange($locations);
    }

    /**
     * Check if a range was founded and create a range.
     *
     * @param $locations
     */
    public function checkAndCreateRange($locations)
    {
        if (RangesHelper::rangeFounded($this->currentParameters['start_position'], $this->currentParameters['end_position'])) {
            $this->ranges[] = $locations->collection
                ->slice(
                    $this->currentParameters['start_position'], $this->currentParameters['end_position'] - $this->currentParameters['start_position'] + 1
                )
                ->values();

            $this->currentParameters['end_position'] = null;
            $this->currentParameters['start_position'] = null;
        }
    }

    /**
     * Check if movement status is now stopped.
     */
    public function checkMovingIsNowStopped()
    {
        if (RangesHelper::movingIsNowStopped($this->currentParameters['moving'], $this->current['location'])) {
            $this->currentParameters['moving'] = false;

            $this->currentParameters['end_position'] = $this->current['index'];
        }
    }

    /**
     * Check if movement status is now in moving.
     */
    public function checkStoppedIsNowMoving()
    {
        if (RangesHelper::stoppedIsNowMoving($this->currentParameters['moving'], $this->current['location'])) {
            $this->currentParameters['moving'] = true;

            $this->currentParameters['start_position'] = $this->current['index'];
        }
    }

    /**
     * Calculate values by a range per day.
     *
     * @param $ranges
     * @param $day
     * @return array
     */
    public function calculateValues($ranges, $day)
    {
        // Return empty summary if ranges is empty
        if (count($ranges) == 0) {
            return $this->generateEmptySummary($day);
        }

        // Calculate range values
        $calc = $this->calculateRangeValues($ranges);

        // Get the last range
        $lastRange = $ranges[count($ranges) - 1];

        // Set the first and last value of all ranges
        $first = $ranges[0][0];
        $last = $lastRange[count($lastRange) - 1];

        return $this->generateValuesSummary($day, $first, $last, $calc);
    }

    /**
     * Generate values summary
     *
     * @param $day
     * @param $first
     * @param $last
     * @param $calc
     * @return array
     */
    public function generateValuesSummary($day, $first, $last, $calc)
    {
        return [
            "summary" => $this->generateSummary($day, $first, $last, $calc["sumDiffInSeconds"]),
            "start_point" => $this->generatePointSummary($first),
            "end_point" => $this->generatePointSummary($last),
            "ranges" => $calc["values"],
        ];
    }

    /**
     * Calculate range value
     *
     * @param $ranges
     * @return array
     */
    public function calculateRangeValues($ranges)
    {
        $values = [];
        $sumDiffInSeconds = 0;

        foreach ($ranges as $range) {
            if (count($range) > 0) {
                $first = $range[0];
                $last = $range[count($range) - 1];

                $diffInSeconds = $first->generated_at->diffInSeconds($last->generated_at);

                $sumDiffInSeconds += $diffInSeconds;

                $values[] = $this->generateValueData($first, $last, $diffInSeconds);
            }
        }

        return [
            "values" => $values,
            "sumDiffInSeconds" => $sumDiffInSeconds,
        ];
    }

    /**
     * Generate value from data
     *
     * @param $first
     * @param $last
     * @param $diffInSeconds
     * @return array
     */
    public function generateValueData($first, $last, $diffInSeconds)
    {
        return [
            "summary" => $this->generateValueSummary($first, $last, $diffInSeconds),
            "from" => $this->generatePointSummary($first),
            "to" => $this->generatePointSummary($last),
            "battery" => $this->generateBatterySummary($first, $last),
        ];
    }

    /**
     * Generate battery summary
     *
     * @param $first
     * @param $last
     * @return array
     */
    public function generateBatterySummary($first, $last)
    {
        return [
            "start" => round($first->battery_level * 100),
            "end" => round($last->battery_level * 100),
            "usage" => round(($first->battery_level - $last->battery_level) * 100),
        ];
    }

    /**
     * Generate value summary
     *
     * @param $start
     * @param $last
     * @param $diffInSeconds
     * @return array
     */
    public function generateValueSummary($start, $last, $diffInSeconds)
    {
        return [
            "status" => 200,
            "time" => gmdate('H:i:s', $diffInSeconds),
            "distance" => ($last->odometer - $start->odometer),
            "altitude" => ($last->altitude - $start->altitude),
        ];
    }

    /**
     * Generate a day summary.
     *
     * @param Carbon $day
     * @param Location $first
     * @param Location $last
     * @param $sumDiffInSeconds
     * @return array
     */
    public function generateSummary(Carbon $day, Location $first, Location $last, $sumDiffInSeconds)
    {
        return [
            "status" => 200,
            "from" => $day->format('Y-m-d 00:00:00'),
            "to" => $day->format('Y-m-d 23:59:59'),
            "in_moving_time" => gmdate('H:i:s', $sumDiffInSeconds),
            "stopped_time" => gmdate('H:i:s', 86400 - $sumDiffInSeconds),
            "distance" => ($last->odometer - $first->odometer),
            "altitude" => ($last->altitude - $first->altitude),
        ];
    }

    /**
     * Generate report per day
     *
     * @param $locations
     * @param $day
     * @return array
     */
    public function generateReportPerDay($locations, Carbon $day)
    {
        // Transform raw locations into locations collection
        $collection = new LocationCollection(
            $locations->values()
        );

        // Extract ranges from locations collection
        $ranges = $this->generateRanges($collection);

        // Calculate values from ranges
        $values = $this->calculateValues($ranges, $day);

        return $values;
    }
}
