<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\ShowRequest;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ShowRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, $resource)
    {
        $resource->load($resource->lazy_relationships);
        return response()->json($resource,200);
    }
}
