<?php

namespace App\Http\Controllers\Api\Near\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Near\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Retrieve paginated near instances.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $resources = finder()->findNearResources($resource, input('coordinates'))->paginate(20);
        return response()->json($resources,200);
    }
}
