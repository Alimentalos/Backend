<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Photos\StoreRequest;
use App\Repositories\ModelLocationsRepository;
use App\Repositories\PhotoRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        // TODO - Reduce number of lines of Resource Photos StoreController
        // @body move into repository method as fetchViaRequest.
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
