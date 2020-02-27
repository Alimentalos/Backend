<?php

namespace App\Http\Controllers\Api\Devices\Geofences;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\Geofences\AccessesRequest;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * Fetch all Accesses of a Device.
     *
     * @param AccessesRequest $request
     * @param Device $device
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, Device $device)
    {
        return response()->json(
            $device->accesses()->with([
                'accessible', 'geofence', 'first_location', 'last_location'
            ])->latest()->paginate(20),
            200
        );
    }
}
