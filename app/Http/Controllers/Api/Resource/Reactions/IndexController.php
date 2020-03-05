<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use App\Repositories\ReactionsRepository;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Retrieve reactions of resource.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        return response()->json(reactions()->fetchViaRequest($resource),200);
    }
}
