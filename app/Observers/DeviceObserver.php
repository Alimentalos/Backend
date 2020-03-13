<?php

namespace App\Observers;

use App\Device;
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
            abort(500);
        }
        // @codeCoverageIgnoreEnd
        $device->uuid = uuid();
    }
}
