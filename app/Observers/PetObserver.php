<?php

namespace App\Observers;

use App\Pet;
use App\Repositories\UniqueNameRepository;
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
            $pet->uuid = UniqueNameRepository::createIdentifier();
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            // TODO - Handle random bytes exception.
        }
        // @codeCoverageIgnoreEnd
    }
}
