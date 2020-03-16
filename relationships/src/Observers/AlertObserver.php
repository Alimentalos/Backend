<?php

namespace Demency\Relationships\Observers;

use Demency\Relationships\Models\Alert;

class AlertObserver
{
    /**
     * Handle the alert "creating" event.
     *
     * @param Alert $alert
     * @return void
     */
    public function creating(Alert $alert)
    {
        $alert->uuid = uuid();
    }
}
