<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\AttachRequest;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * Attach resource in Geofence.
     *
     * @param AttachRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, $resource, Geofence $geofence)
    {
        $resource->geofences()->attach($geofence->id);
        return response()->json([], 200);
    }
}
