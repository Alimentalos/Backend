<?php

namespace App\Repositories;

use App\Device;
use App\Http\Resources\Device as DeviceResource;
use App\Lists\DeviceList;
use App\Procedures\DeviceProcedure;

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
