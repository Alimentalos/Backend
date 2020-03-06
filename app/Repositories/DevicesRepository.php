<?php

namespace App\Repositories;

use App\Device;
use App\Http\Resources\Device as DeviceResource;
use App\Lists\DeviceList;

class DevicesRepository
{
    use DeviceList;

    /**
     * Create device via request.
     *
     * @return DeviceResource
     */
    public static function createViaRequest()
    {
        $device = Device::create([
            'name' => input('name'),
            'description' => input('description'),
            'user_uuid' => authenticated()->uuid,
            'is_public' => input('is_public'),
        ]);
        return (new DeviceResource($device));
    }

    /**
     * Update device via request.
     *
     * @param Device $device
     * @return DeviceResource
     */
    public function updateViaRequest(Device $device)
    {
        $device->update(parameters()->fill(['name', 'description', 'is_public'], $device));

        return new DeviceResource($device);
    }
}
