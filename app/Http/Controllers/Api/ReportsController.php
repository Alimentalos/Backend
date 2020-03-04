<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\FillRepository;
use App\Repositories\ReportRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Generate report as JSON object.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        // TODO - Reduce number of lines of ReportsController
        // @body move into repository method as createViaRequest.
        $data = ReportRepository::generateData( // Generate data
            $request->input('devices'), // of those devices
            $request->input('start_date'), // between an start date
            $request->input('end_date'), // and end date
            $request->only( // including required parameters
                ReportRepository::requiredParameters(
                    FillRepository::fillMethod($request, 'type', ReportRepository::$defaultType)
                )
            )
        );

        return response()->json(
            $data,
            200
        );
    }
}
