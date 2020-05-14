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
        // Marker
        $marker_uuid = uuid();
        photos()->storePhoto($marker_uuid, uploaded('marker'));

        $properties = [
            'name' => input('name'),
            'description' => input('description'),
            'user_uuid' => authenticated()->uuid,
            'is_public' => input('is_public'),
            'marker' => config('storage.path') . 'markers/' . ($marker_uuid . '.' . uploaded('marker')->extension()),
        ];

        $fill = array_map(
            function($prop) {
                return fill($prop, null);
            },
            Device::getColors()
        );

        $device = Device::create(array_merge($properties, $fill));
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
        // Marker
        if (rhas('marker')) {
            $marker_uuid = uuid();
            photos()->storePhoto($marker_uuid, uploaded('marker'));
            $device->update([
                'marker' => config('storage.path') . 'markers/' . ($marker_uuid . '.' . uploaded('marker')->extension())
            ]);
        }

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
