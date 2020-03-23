<?php

namespace Demency\Relationships\Observers;

use Demency\Relationships\Models\Pet;
use Exception;

class PetObserver
{
    /**
     * Handle the device "creating" event.
     *
     * @param Pet $pet
     * @return void
     */
    public function creating(Pet $pet)
    {
        try {
            $pet->api_token = bin2hex(random_bytes(16));
            $pet->uuid = uuid();
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            abort(500);
        }
        // @codeCoverageIgnoreEnd
    }
}
