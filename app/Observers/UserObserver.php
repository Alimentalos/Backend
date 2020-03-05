<?php

namespace App\Observers;

use App\User;
use Exception;
use Illuminate\Auth\Events\Registered;

class UserObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param User $user
     * @return void
     */
    public function creating(User $user)
    {
        try {
            $user->api_token = bin2hex(random_bytes(16));
            $user->uuid = uuid();
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            // TODO - Handle random bytes exception.
        }
    }
    // @codeCoverageIgnoreEnd

    /**
     * Handle the user "created" event.
     *
     * @param User $user
     */
    public function created(User $user)
    {
        event(new Registered($user));
    }
}
