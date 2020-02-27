<?php

namespace App\Http\Controllers\Api\Devices\Geofences\Accesses;

use App\Device;
use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\Geofences\Accesses\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Accesses of a Device using specific Geofence.
     *
     * @param IndexRequest $request
     * @param Device $device
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Device $device, Geofence $geofence)
    {
        return response()->json(
            $device->accesses()->latest()->with([
                'accessible', 'geofence', 'first_location', 'last_location'
            ])->where([
                ['geofence_id', $geofence->id]
            ])->latest()->paginate(20),
            200
        );
    }
}
