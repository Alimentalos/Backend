<?php

namespace App\Observers;

use App\Device;
use Exception;
use Webpatser\Uuid\Uuid;

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
        $device->uuid = Uuid::generate()->string;
    }
}
