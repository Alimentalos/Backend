<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Retrieve reactions of instance.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $reactions = reactions()->fetchViaRequest($resource);
        return response()->json($reactions,200);
    }
}
