<?php

namespace App\Http\Controllers\Api\Devices\Geofences;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\Geofences\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Geofences of Device.
     *
     * @param IndexRequest $request
     * @param Device $device
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Device $device)
    {
        return response()->json(
            $device->geofences()->latest()->with('user', 'photo')->paginate(20),
            200
        );
    }
}
