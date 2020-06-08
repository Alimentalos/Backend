<?php

namespace Alimentalos\Relationships\Observers;

use Alimentalos\Relationships\Models\Photo;

class PhotoObserver
{
    /**
     * Handle the photo "creating" event.
     *
     * @param Photo $photo
     * @return void
     */
    public function creating(Photo $photo)
    {
//        $photo->uuid = uuid();
        $photo->user_uuid = authenticated() ? authenticated()->uuid : null;
    }
}
