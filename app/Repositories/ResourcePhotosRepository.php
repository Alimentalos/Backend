<?php

namespace App\Repositories;

use App\Photo;
use Illuminate\Http\Request;

class ResourcePhotosRepository
{
    /**
     * Create resource photo via request.
     *
     * @param Request $request
     * @param $resource
     * @return Photo
     */
    public static function createPhotoViaRequest(Request $request, $resource)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $resource = ModelLocationsRepository::updateModelLocation($request, $resource);
        $resource->photos()->attach($photo->uuid);
        $photo->load('comment');
        return $photo;
    }
}
