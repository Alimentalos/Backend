<?php

namespace App\Observers;

use App\Models\Place;

class PlaceObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param Place $place
     * @return void
     */
    public function creating(Place $place)
    {
        $place->uuid = uuid();
        $place->user_uuid = authenticated() ? authenticated()->uuid : null;
    }
}
