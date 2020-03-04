<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Reactions\StoreRequest;
use App\Repositories\LikeRepository;
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
        LikeRepository::updateLike($resource->getLoveReactant(), $request->user('api')->getLoveReacter(), $request->input('type'));
        return response()->json([],200);
    }
}
