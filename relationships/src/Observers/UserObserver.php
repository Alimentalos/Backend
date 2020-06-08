<?php

namespace Alimentalos\Relationships\Observers;

use Alimentalos\Relationships\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;

class UserObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param User $user
     * @return void
     * @throws Exception
     */
    public function creating(User $user)
    {
        $user->api_token = bin2hex(random_bytes(16));
        $user->uuid = uuid();
        $user->user_uuid = authenticated() ? authenticated()->uuid : null;
    }

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
