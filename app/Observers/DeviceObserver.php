<?php

namespace App\Observers;

use App\Device;
use App\Repositories\UniqueNameRepository;
use Exception;

class DeviceObserver
{
    /**
     * Handle the device "creating" event.
     *
     * @param Device $device
     * @return void
     */
    public function creating(Device $device)
    {
        try {
            $device->api_token = bin2hex(random_bytes(16));
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            // TODO - Handle random bytes exception.
        }
        // @codeCoverageIgnoreEnd
        $device->uuid = uuid();
    }
}
