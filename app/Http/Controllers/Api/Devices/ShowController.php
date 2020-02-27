<?php

namespace App\Http\Controllers\Api\Devices;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\ShowRequest;
use App\Http\Resources\Device as DeviceResource;

class ShowController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param Device $device
     * @return DeviceResource
     */
    public function __invoke(ShowRequest $request, Device $device)
    {
        return new DeviceResource($device);
    }
}
