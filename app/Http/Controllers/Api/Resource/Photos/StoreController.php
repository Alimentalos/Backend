<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Photos\StoreRequest;
use App\Repositories\ModelLocationsRepository;
use App\Repositories\PhotoRepository;
use App\User;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, $resource)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $resource = ModelLocationsRepository::updateModelLocation($request, $resource);
        $resource->photos()->attach($photo->uuid);
        $photo = $photo->load('comment');
        return response()->json(
            $photo,
            200
        );
    }
}
