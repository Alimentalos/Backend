<?php

namespace App\Reports\Types;

use App\Http\Resources\Location;
use App\Http\Resources\LocationCollection;
use Carbon\Carbon;

class Activity extends Type
{

    /**
     * Get Activity report as Array
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
            // Filter the specified device locations
            $device_locations = $locations->where('trackable_id', $device->id)
                ->where('trackable_type', 'App\\Device')->reverse()->values();

            if ($this->start_day == $this->end_day) {
                $data = [];

                // Push the per day report into data array
                $data[] = $this->generateReportPerDay($device_locations, Carbon::parse($this->start_date));

                // Push the required report into reports array
                $this->reports[] = $this->generateReport($device, $data);
            } else {
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
        }
        return $this->reports;
    }

    /**
     * Generate ranges using collection of locations
     *
     * @param $collection
     * @return array
     */
    public function generateRanges($collection)
    {
        $ranges = [];

        // Checkpoints
        $moving = false;
        $start_position = null;
        $end_position = null;

        // Running through data
        foreach ($collection as $key => $location) {
            // Currently isn't moving but the currently location is moving
            if ($moving == false && $location->is_moving) {
                // Set moving flag to true
                $moving = true;
                // Set the current location as the start position

                $start_position = [
                    "key" => $key,
                ];
            }
            if ($moving == true && !$location->is_moving) {
                // Set moving flag to false
                $moving = false;

                // Set the current location as the end position
                $end_position = [
                    "key" => $key,
                ];
            }

            // Check the start and end position to group locations
            if ($end_position != null && $start_position != null) {
                // Slice positions using keys
                $ranges[] = $collection->collection
                    ->slice($start_position["key"], $end_position["key"] - $start_position["key"] + 1)
                    ->values();

                // Clean checkpoints
                $end_position = null;
                $start_position = null;
            }
        }

        return $ranges;
    }

    /**
     * Calculate values by a range per day
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
