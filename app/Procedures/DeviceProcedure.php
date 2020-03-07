<?php


namespace App\Procedures;


use App\Device;
use App\Http\Resources\Device as DeviceResource;

trait DeviceProcedure
{
    /**
     * Create device instance.
     *
     * @return DeviceResource
     */
    public function createInstance()
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
     * Update device instance.
     *
     * @param Device $device
     * @return DeviceResource
     */
    public function updateInstance(Device $device)
    {
        $device->update(parameters()->fill(['name', 'description', 'is_public'], $device));

        return new DeviceResource($device);
    }
}
