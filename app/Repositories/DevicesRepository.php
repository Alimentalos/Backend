<?php

namespace App\Repositories;

use Alimentalos\Relationships\Lists\DeviceList;
use App\Models\Device;
use Alimentalos\Relationships\Procedures\DeviceProcedure;

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
