<?php

namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Procedures\PhotoProcedure;

class PhotosRepository
{
    use PhotoProcedure;

    /**
     * Default photo disk path.
     */
    public const DEFAULT_PHOTOS_DISK_PATH = 'photos/';

    /**
     * Default disk.
     */
    public const DEFAULT_DISK = 'public';

    /**
     * Update photo via request.
     *
     * @param Photo $photo
     * @return Photo
     */
    public function update(Photo $photo)
    {
        $photo->update(parameters()->fill(['title', 'body', 'is_public'], $photo));
        return $photo;
    }

    /**
     * Create photo via request.
     *
     * @return Photo
     */
    public function create()
    {
        $photo = $this->createInstance();
        $this->storePhoto($photo->uuid, uploaded('photo'));
        return $photo;
    }
}
