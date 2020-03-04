<?php

namespace App\Http\Controllers\Api\Resource\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Comments\StoreRequest;
use App\Repositories\ResourceCommentsRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        return response()->json(ResourceCommentsRepository::createCommentViaRequest($request, $resource),200);
    }
}
