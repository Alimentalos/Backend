<?php


namespace Demency\Tools;


class Measurer
{
    /**
     * Transform speed from kilometers per second to meters per second.
     *
     * @param $speed
     * @return float|int
     */
    public function transformKilometersToMeters($speed) { return (($speed * 1000) / 60) / 60; }

    /**
     * Transform speed from meters per second to kilometers per second.
     * @param $speed
     * @return float|int
     */
    public function transformMetersToKilometers($speed) { return (($speed * 60) * 60) / 1000; }
}
