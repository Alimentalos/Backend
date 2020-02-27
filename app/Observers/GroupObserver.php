<?php

namespace App\Observers;

use App\Group;
use Exception;
use Webpatser\Uuid\Uuid;

class GroupObserver
{
    /**
     * Handle the device "creating" event.
     *
     * @param Group $group
     * @return void
     * @throws Exception
     */
    public function creating(Group $group)
    {
        $group->uuid = Uuid::generate()->string;
    }
}
