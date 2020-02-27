<?php

namespace App\Http\Controllers\Api\Devices\Geofences;

use App\Device;
use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\Geofences\AttachRequest;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * Attach Device in Geofence.
     *
     * @param AttachRequest $request
     * @param Device $device
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, Device $device, Geofence $geofence)
    {
        $device->geofences()->attach($geofence->id);
        return response()->json([], 200);
    }
}
