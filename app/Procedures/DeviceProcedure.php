<?php


namespace App\Procedures;


use App\Device;

trait DeviceProcedure
{
    /**
     * Create device instance.
     *
     * @return Device
     */
    public function createInstance()
    {
        $device = Device::create([
            'name' => input('name'),
            'description' => input('description'),
            'user_uuid' => authenticated()->uuid,
            'is_public' => input('is_public'),
        ]);
        return $device;
    }

    /**
     * Update device instance.
     *
     * @param Device $device
     * @return Device
     */
    public function updateInstance(Device $device)
    {
        $device->update(parameters()->fill(['name', 'description', 'is_public'], $device));

        return $device;
    }
}
