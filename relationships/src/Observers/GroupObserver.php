<?php

namespace Alimentalos\Relationships\Observers;

use App\Models\Group;

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
        $group->user_uuid = authenticated() ? authenticated()->uuid : null;
    }
}
