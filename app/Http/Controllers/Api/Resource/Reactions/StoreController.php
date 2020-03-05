<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Reactions\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Store reaction of instance.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        likes()->updateLike($resource->getLoveReactant(), authenticated()->getLoveReacter(), input('type'));
        return response()->json([],200);
    }
}
