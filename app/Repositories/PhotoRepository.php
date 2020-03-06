<?php

namespace App\Repositories;

use App\Photo;
use App\Procedures\PhotoProcedure;

class PhotoRepository
{
    use PhotoProcedure;

    /**
     * Default photo disk path.
     */
    public const DEFAULT_PHOTOS_DISK_PATH = 'photos/';

    /**
     * Default disk.
     */
    public const DEFAULT_DISK = 'gcs';

    /**
     * Update photo via request.
     *
     * @param Photo $photo
     * @return Photo
     */
    public function updateViaRequest(Photo $photo)
    {
        $photo->update(parameters()->fill(['title', 'description', 'is_public'], $photo));
        $photo->load('user');
        return $photo;
    }

    /**
     * Create photo via request.
     *
     * @return Photo
     */
    public function createViaRequest()
    {
        $photo = $this->createInstance();
        $this->createComment($photo);
        $this->storePhoto($photo->uuid, uploaded('photo'));
        return $photo;
    }
}
