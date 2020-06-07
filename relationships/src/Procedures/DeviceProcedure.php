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

        $fill = array_map(
            fn($prop) => fill($prop, null),
            Device::getColors()
        );

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

        $device->update(
            parameters()->fill(
                array_merge(
                    [
                        'name',
                        'description',
                        'is_public',
                    ],
                    Device::getColors()
                ),
                $device
            )
        );

        return $device;
    }
}
