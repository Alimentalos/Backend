<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;

use App\Repositories\LikeRepository;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        // TODO - Reduce number of lines of Resource ReactionsController
        // @body move into repository method as fetchViaRequest.
        $stats = binder()::bindResource(get_class($resource))::AVAILABLE_REACTIONS == 'Follow' ?
            LikeRepository::generateFollowStats($resource->getLoveReactant(), $request->user('api')->getLoveReacter()) :
            LikeRepository::generateStats($resource->getLoveReactant(), $request->user('api')->getLoveReacter());
        return response()->json(
            $stats,
            200
        );
    }
}
