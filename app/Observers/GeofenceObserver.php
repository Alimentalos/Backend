<?php

namespace App\Observers;

use App\Models\Geofence;

class GeofenceObserver
{
    /**
     * Handle the geofence "creating" event.
     *
     * @param Geofence $geofence
     * @return void
     */
    public function creating(Geofence $geofence)
    {
        $geofence->uuid = uuid();
    }
}
