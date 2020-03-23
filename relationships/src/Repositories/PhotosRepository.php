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
        $photo->update(parameters()->fill(['title', 'description', 'is_public'], $photo));
        $photo->comment->update(array_merge(
            parameters()->fill(['title', 'is_public'], $photo->comment),
            ['body' => fill('body', $photo->comment->body)]
        ));
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
        $this->createComment($photo);
        $this->storePhoto($photo->uuid, uploaded('photo'));
        return $photo;
    }
}
