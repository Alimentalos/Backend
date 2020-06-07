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
        $properties = [
            'name' => input('name'),
            'description' => input('description'),
            'user_uuid' => authenticated()->uuid,
            'is_public' => input('is_public'),
        ];

        foreach (Device::getColors() as $color) {
            $fill[$color] = fill($color, null);
        }

        $device = Device::create(array_merge($properties, $fill));

        // Marker
        upload()->checkMarker($device);

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
        upload()->checkMarker($device);
        fillAndUpdate($device, ['name', 'description', 'is_public'], Device::getColors());
        return $device;
    }
}
