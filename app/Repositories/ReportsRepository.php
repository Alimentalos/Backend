<?php

namespace App\Repositories;

use App\Reports\Report;
use Illuminate\Http\Request;

class ReportsRepository
{
    /**
     * Default report type
     *
     * @var string
     */
    public static $defaultType = 'activity';

    /**
     * Available reports
     *
     * @var array
     */
    protected static $availableReports = [
        'activity' => [
            'parameters' => [],
        ],
        'speed' => [
            'parameters' => ['min', 'max']
        ],
    ];

    /**
     * Default required parameters
     *
     * @var array
     */
    protected static $defaultParameters = [
        'type',
        'accuracy'
    ];

    public static function fetchViaRequest(Request $request)
    {
        return ReportsRepository::generateData($request->input('devices'), $request->input('start_date'), $request->input('end_date'), $request->only(ReportsRepository::requiredParameters(FillRepository::fillMethod($request, 'type', ReportsRepository::$defaultType))));
    }

    /**
     * Generate report data
     *
     * @param $devices
     * @param $start_date
     * @param $end_date
     * @param $parameters
     * @return array
     */
    public static function generateData($devices, $start_date, $end_date, $parameters)
    {
        if ($devices == '') {
            $devices = DevicesRepository::fetchInDatabase($devices);
        }
        return (new Report(
            $devices,
            $start_date,
            $end_date,
            $parameters
        ))->fetchData();
    }

    /**
     * Get required parameters
     *
     * @param $type
     * @return array
     */
    public static function requiredParameters($type)
    {
        return array_merge(self::$defaultParameters, self::$availableReports[$type]['parameters']);
    }
}
