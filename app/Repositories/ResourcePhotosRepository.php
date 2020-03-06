<?php

namespace App\Repositories;

use App\Contracts\Resource;
use App\Photo;

class ResourcePhotosRepository
{
    /**
     * Create resource photo via request.
     *
     * @param Resource $resource
     * @return Photo
     */
    public function createViaRequest(Resource $resource)
    {
        $photo = photos()->createViaRequest();
        $resource = modelLocations()->update($resource);
        $resource->photos()->attach($photo->uuid);
        $photo->load('comment');
        return $photo;
    }
}
