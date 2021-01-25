<?php

namespace App\Observers;

use App\Models\Pet;
use Exception;

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
        $pet->api_token = bin2hex(random_bytes(16));
        $pet->uuid = uuid();
        $pet->user_uuid = authenticated() ? authenticated()->uuid : null;
    }
}
