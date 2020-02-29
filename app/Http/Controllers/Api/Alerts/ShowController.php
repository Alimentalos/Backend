<?php

namespace App\Http\Controllers\Api\Alerts;

use App\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Alerts\ShowRequest;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ShowRequest $request
     * @param Alert $alert
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, Alert $alert)
    {
        $alert->load('user', 'photo', 'alert');
        return response()->json(
            $alert,
            200
        );
    }
}
