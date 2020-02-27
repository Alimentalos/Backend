<?php

namespace App\Http\Controllers\Api\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\ShowRequest;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * @param ShowRequest $request
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, Geofence $geofence)
    {
        $geofence->load('user', 'photo');
        return response()->json(
            $geofence,
            200
        );
    }
}
