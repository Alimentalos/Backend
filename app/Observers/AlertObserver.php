<?php

namespace App\Observers;

use App\Alert;
use Exception;
use Webpatser\Uuid\Uuid;

class AlertObserver
{
    /**
     * Handle the alert "creating" event.
     *
     * @param Alert $alert
     * @return void
     * @throws Exception
     */
    public function creating(Alert $alert)
    {
        $alert->uuid = Uuid::generate()->string;
    }
}
