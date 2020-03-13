<?php

namespace App\Observers;

use App\Place;
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
        try {
            $place->uuid = uuid();
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            abort(500);
        }
    }
    // @codeCoverageIgnoreEnd
}
