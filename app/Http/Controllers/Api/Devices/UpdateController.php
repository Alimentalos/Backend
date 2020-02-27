<?php

namespace App\Http\Controllers\Api\Devices;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\UpdateRequest;
use App\Http\Resources\Device as DeviceResource;
use App\Repositories\FillRepository;

class UpdateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Device $device
     * @return DeviceResource
     */
    public function __invoke(UpdateRequest $request, Device $device)
    {
        $device->update([
            'name' => FillRepository::fillMethod($request, 'name', $device->name),
            'description' => FillRepository::fillMethod($request, 'description', $device->description),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $device->is_public)
        ]);

        return new DeviceResource($device);
    }
}
