<?php


namespace Demency\Tools;


use Demency\Tools\Contracts\CanGenerateReports;
use Demency\Tools\Procedures\ReportProcedure;

class Reporter implements CanGenerateReports
{
    use ReportProcedure;

    /**
     * Default report type
     *
     * @var string
     */
    public const DEFAULT_TYPE = 'activity';

    /**
     * @return array
     */
    public function get()
    {
        return $this->retrieve(input('devices'), input('start_date'), input('end_date'));
    }
}
