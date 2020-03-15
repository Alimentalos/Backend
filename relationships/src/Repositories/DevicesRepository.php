<?php

namespace Demency\Relationships\Repositories;

use App\Device;
use Demency\Relationships\Lists\DeviceList;
use Demency\Relationships\Procedures\DeviceProcedure;

class DevicesRepository
{
    use DeviceList;
    use DeviceProcedure;

    /**
     * Create device.
     *
     * @return Device
     */
    public function create()
    {
        return $this->createInstance();
    }

    /**
     * Update device via request.
     *
     * @param Device $device
     * @return Device
     */
    public function update(Device $device)
    {
        return $this->updateInstance($device);
    }
}
