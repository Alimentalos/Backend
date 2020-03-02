<?php

namespace App\Http\Controllers\Api\Alerts;

use App\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Alerts\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param DestroyRequest $request
     * @param Alert $alert
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, Alert $alert)
    {
        try {
            $alert->delete();

            return response()->json(
                ['message' => 'Deleted successfully.'],
                200
            );
        } catch (Exception $exception) {
            return response()->json(
                ['message' => 'Resource cannot be deleted.'],
                500
            );
        }
    }
}
