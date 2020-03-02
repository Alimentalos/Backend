<?php

namespace App\Parsers;

use Carbon\Carbon;
use Grimzy\LaravelMysqlSpatial\Types\Point;

trait LocationParser
{
    /**
     * Parse data latitude and longitude to Spatial Point type
     *
     * @param $data
     * @return Point
     */
    public static function parsePoint($data)
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
    public static function parsePointFromCoordinates($coordinates)
    {
        $exploded = explode(',', $coordinates);
        return (new Point(
            floatval($exploded[0]),
            floatval($exploded[1])
        ));
    }

    /**
     * Parse data timestamp adding the timezone offset
     *
     * @param $data
     * @return Carbon
     */
    public static function parseTimestamp($data)
    {
        return Carbon::parse($data["location"]["timestamp"])->subHours(3);
    }

    /**
     * Parse data event type
     *
     * @param $data
     * @return string|null
     */
    public static function parseEvent($data)
    {
        return array_key_exists("event", $data["location"]) ? $data["location"]["event"] : 'default';
    }
}
