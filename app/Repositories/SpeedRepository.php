<?php

namespace App\Repositories;

class SpeedRepository
{
    /**
     * Transform speed from kilometers per second to meters per second.
     *
     * @param $speed
     * @return float|int
     */
    public static function transformKilometersToMeters($speed)
    {
        return (($speed * 1000) / 60) / 60;
    }

    /**
     * Transform speed from meters per second to kilometers per second.
     * @param $speed
     * @return float|int
     */
    public static function transformMetersToKilometers($speed)
    {
        return (($speed * 60) * 60) / 1000;
    }
}
