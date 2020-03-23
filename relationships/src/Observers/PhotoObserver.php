<?php

namespace Demency\Relationships\Observers;

use Demency\Relationships\Models\Photo;

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
    }
}
