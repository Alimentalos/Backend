<?php

namespace App\Http\Controllers\Api\Devices\Geofences;

use App\Device;
use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\Geofences\DetachRequest;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * Detach Device of Geofence.
     *
     * @param DetachRequest $request
     * @param Device $device
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, Device $device, Geofence $geofence)
    {
        $device->geofences()->detach($geofence->id);
        return response()->json([], 200);
    }
}
