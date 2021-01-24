<?php

namespace Alimentalos\Relationships\Observers;

use App\Models\Device;
use Exception;

class DeviceObserver
{
    /**
     * Handle the device "creating" event.
     *
     * @param Device $device
     * @return void
     * @throws Exception
     */
    public function creating(Device $device)
    {
        $device->api_token = bin2hex(random_bytes(16));
        $device->uuid = uuid();
        $device->user_uuid = authenticated() ? authenticated()->uuid : null;
    }
}
