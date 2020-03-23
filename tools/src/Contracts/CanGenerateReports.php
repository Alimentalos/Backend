<?php


namespace Demency\Tools\Contracts;


interface CanGenerateReports
{
    /**
     * Generate report data
     *
     * @param $devices
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public function retrieve($devices, $start_date, $end_date);

    /**
     * Get required parameters
     *
     * @param $type
     * @return array
     */
    public function retrieveRequiredParameters($type);
}
