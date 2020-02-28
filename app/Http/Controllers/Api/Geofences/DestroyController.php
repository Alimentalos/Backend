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
     * @throws Exception
     */
    public function __invoke(DestroyRequest $request, Geofence $geofence)
    {
        $geofence->delete();
        return response()->json(
            [],
            200
        );
    }
}
