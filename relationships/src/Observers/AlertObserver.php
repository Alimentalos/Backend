<?php

namespace Alimentalos\Relationships\Observers;

use Alimentalos\Relationships\Models\Alert;

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
