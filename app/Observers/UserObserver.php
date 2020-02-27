<?php

namespace App\Observers;

use App\User;
use Exception;
use Webpatser\Uuid\Uuid;

class UserObserver
{
    /**
     * Handle the device "creating" event.
     *
     * @param User $user
     * @return void
     * @throws Exception
     */
    public function creating(User $user)
    {
        $user->api_token = bin2hex(random_bytes(16));
        $user->uuid = Uuid::generate()->string;
    }
}
