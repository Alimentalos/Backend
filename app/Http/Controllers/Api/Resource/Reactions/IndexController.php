<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;

use App\Repositories\LikeRepository;
use App\Repositories\ReactionsRepository;
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
        return response()->json(ReactionsRepository::fetchViaRequest($request, $request),200);
    }
}
