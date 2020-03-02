<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\DetachRequest;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * Detach resource of Geofence.
     *
     * @param DetachRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, $resource, Geofence $geofence)
    {
        $resource->geofences()->detach($geofence->id);
        return response()->json([], 200);
    }
}
