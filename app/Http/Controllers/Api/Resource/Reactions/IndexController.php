<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/reactions",
     *      operationId="getResourceReactions",
     *      tags={"Resources"},
     *      summary="Get resource reactions stats.",
     *      description="Returns the resource reactions stats.",
     *      @OA\Parameter(
     *          name="resource",
     *          description="Resource class type",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource reactions retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Get resource reactions stats.
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
