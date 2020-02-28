<?php


namespace App\Reports\Helpers;


class RangesHelper
{
    /**
     * @param $moving
     * @param $location
     * @return bool
     */
    public static function stoppedIsNowMoving($moving, $location)
    {
        return $moving == false && $location->is_moving;
    }

    /**
     * @param $moving
     * @param $location
     * @return bool
     */
    public static function movingIsNowStopped($moving, $location)
    {
        return $moving == true && !$location->is_moving;
    }

    /**
     * @param $start_position
     * @param $end_position
     * @return bool
     */
    public static function rangeFounded($start_position, $end_position)
    {
        return !is_null($end_position) && !is_null($start_position);
    }
}
