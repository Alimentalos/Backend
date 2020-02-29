<?php

namespace App\Http\Controllers\Api\Alerts;

use App\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Models\UpdateRequest;
use App\Repositories\AlertsRepository;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param UpdateRequest $request
     * @param Alert $alert
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Alert $alert)
    {
        $alert = AlertsRepository::updateAlertViaRequest($request, $alert);
        return response()->json($alert, 200);
    }
}
