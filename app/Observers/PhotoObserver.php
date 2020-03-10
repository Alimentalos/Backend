<?php

namespace App\Observers;

use App\Photo;

class PhotoObserver
{
    /**
     * Handle the photo "creating" event.
     *
     * @param  \App\Photo  $photo
     * @return void
     */
    public function creating(Photo $photo)
    {
//        $photo->uuid = uuid();
    }
}
