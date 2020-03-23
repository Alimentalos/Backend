<?php


namespace Alimentalos\Tools;


use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class Parser
{
    /**
     * Parse data latitude and longitude to Spatial Point type
     *
     * @param $data
     * @return Point
     */
    public function point($data)
    {
        return new Point(
            $data["location"]["coords"]["latitude"],
            $data["location"]["coords"]["longitude"]
        );
    }

    /**
     * Parse coordinates comma-separated latitude and longitude to Spatial Point type.
     *
     * @param $coordinates
     * @return Point
     */
    public function pointFromCoordinates($coordinates)
    {
        $array = explode(',', $coordinates);
        return (new Point(
            floatval($array[locations()->latitude]),
            floatval($array[locations()->longitude])
        ));
    }

    /**
     * Parse data timestamp adding the timezone offset
     *
     * @param $data
     * @return Carbon
     */
    public function timestamp($data)
    {
        return Carbon::parse($data["location"]["timestamp"])->subHours(3);
    }

    /**
     * Parse data event type
     *
     * @param $data
     * @return string|null
     */
    public function event($data)
    {
        return array_key_exists("event", $data["location"]) ? $data["location"]["event"] : 'default';
    }
}
