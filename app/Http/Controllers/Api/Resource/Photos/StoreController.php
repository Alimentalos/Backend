<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Photos\StoreRequest;
use App\Repositories\ResourcePhotosRepository;
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
        return response()->json(ResourcePhotosRepository::createPhotoViaRequest($request, $resource),200);
    }
}
