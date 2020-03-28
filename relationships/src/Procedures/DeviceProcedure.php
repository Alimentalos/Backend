<?php


namespace Alimentalos\Relationships\Procedures;


use Alimentalos\Relationships\Models\Device;

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
            'marker_color' => fill('marker_color', null),
            'color' => fill('color', null),
            'marker' => fill('marker', null),
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
        $device->update(parameters()->fill([
            'name',
            'description',
            'is_public',
            'color',
            'marker'.
            'marker_color'
        ], $device));

        return $device;
    }
}
