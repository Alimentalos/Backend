<?php

namespace Alimentalos\Relationships\Observers;

use Alimentalos\Relationships\Models\Place;
use Exception;

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
    }
}
