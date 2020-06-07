<?php


namespace Alimentalos\Relationships\Procedures;


use Alimentalos\Relationships\Models\Device;

trait DeviceProcedure
{
    /**
     * Current device properties.
     *
     * @var string[]
     */
    protected $deviceProperties = [
        'name',
        'description',
        'is_public'
    ];

    /**
     * Create device instance.
     *
     * @return Device
     */
    public function createInstance()
    {
        $properties = [
            'user_uuid' => authenticated()->uuid,
        ];
        $fill = request()->only(
            array_merge(
                $this->deviceProperties,
                Device::getColors()
            )
        );
        $device = Device::create(array_merge($properties, $fill));
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
        fillAndUpdate($device, $this->deviceProperties, Device::getColors());
        return $device;
    }
}
