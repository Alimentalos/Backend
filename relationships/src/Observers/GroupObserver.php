<?php

namespace Alimentalos\Relationships\Observers;

use Alimentalos\Relationships\Models\Group;

class GroupObserver
{
    /**
     * Handle the device "creating" event.
     *
     * @param Group $group
     * @return void
     */
    public function creating(Group $group)
    {
        $group->uuid = uuid();
    }
}
