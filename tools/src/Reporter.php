<?php


namespace Alimentalos\Tools;


use Alimentalos\Tools\Contracts\CanGenerateReports;
use Alimentalos\Tools\Procedures\ReportProcedure;

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
