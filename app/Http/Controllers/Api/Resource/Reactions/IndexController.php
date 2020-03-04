<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use App\Repositories\HandleBindingRepository;
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
        $stats = HandleBindingRepository::bindResource(get_class($resource))::AVAILABLE_REACTIONS == 'Follow' ?
            LikeRepository::generateFollowStats($resource->getLoveReactant(), $request->user('api')->getLoveReacter()) :
            LikeRepository::generateStats($resource->getLoveReactant(), $request->user('api')->getLoveReacter());
        return response()->json(
            $stats,
            200
        );
    }
}
