<?php

namespace App\Http\Controllers\Api\Resource\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Comments\StoreRequest;
use App\Repositories\ResourceCommentsRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Store comment of resource.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        $comment = resourceComments()->createCommentViaRequest($resource);
        return response()->json($comment,200);
    }
}
