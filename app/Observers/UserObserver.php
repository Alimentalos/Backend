<?php

namespace App\Observers;

use App\Repositories\UniqueNameRepository;
use App\User;
use Exception;

class UserObserver
{
    /**
     * Handle the device "creating" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user)
    {
        try {
            $user->api_token = bin2hex(random_bytes(16));
            $user->uuid = UniqueNameRepository::createIdentifier();
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            // TODO - Handle random bytes exception.
        }
        // @codeCoverageIgnoreEnd
    }
}
