<?php

namespace App\Repositories;

use App\Contracts\Resource;
use App\Photo;
use Illuminate\Http\Request;

class ResourcePhotosRepository
{
    /**
     * Create resource photo via request.
     *
     * @param $resource
     * @return Photo
     */
    public function createPhotoViaRequest(Resource $resource)
    {
        $photo = photos()->createPhotoViaRequest();
        $resource = modelLocations()->updateModelLocation($resource);
        $resource->photos()->attach($photo->uuid);
        $photo->load('comment');
        return $photo;
    }
}
