<?php

namespace App\Http\Controllers\Api\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * @param DestroyRequest $request
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, Geofence $geofence)
    {
        try {
            $geofence->delete();

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
