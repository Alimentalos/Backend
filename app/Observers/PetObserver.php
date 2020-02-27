<?php

namespace App\Observers;

use App\Pet;
use Exception;
use Webpatser\Uuid\Uuid;

class PetObserver
{
    /**
     * Handle the device "creating" event.
     *
     * @param Pet $pet
     * @return void
     * @throws Exception
     */
    public function creating(Pet $pet)
    {
        $pet->uuid = Uuid::generate()->string;
        $pet->api_token = bin2hex(random_bytes(16));
    }
}
