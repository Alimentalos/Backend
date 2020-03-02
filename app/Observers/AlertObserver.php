<?php

namespace App\Observers;

use App\Alert;
use App\Repositories\UniqueNameRepository;

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
        $alert->uuid = UniqueNameRepository::createIdentifier();
    }
}
