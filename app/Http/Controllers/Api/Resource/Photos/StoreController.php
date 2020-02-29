<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Photos\StoreRequest;
use App\Repositories\ModelLocationsRepository;
use App\Repositories\PhotoRepository;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, $resource)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $resource = ModelLocationsRepository::updateModelLocation($request, $resource);
        $resource->photos()->attach($photo->id);
        $photo->load('user', 'comment');
        return response()->json(
            $photo,
            200
        );
    }
}
