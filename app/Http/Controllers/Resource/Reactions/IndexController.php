<?php

namespace App\Http\Controllers\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\Resource\IndexRequest;
use Alimentalos\Contracts\Resource;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/{uuid}/reactions",
     *      operationId="getResourceReactions",
     *      tags={"Resources"},
     *      summary="Get reactions stats of resource.",
     *      description="Returns the reactions stats of resource.",
     *      @OA\Parameter(
     *          name="uuid",
     *          description="Unique identifier of resource",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *         name="resource",
     *         in="path",
     *         description="Resource type that need to be considered",
     *         required=true,
     *         @OA\Schema(
     *         type="string",
     *           @OA\Items(
     *               type="string",
     *               enum={"users", "geofences", "pets", "photos", "comments"},
     *               default="users"
     *           ),
     *         )
     *     ),
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
    public function __invoke(IndexRequest $request, Resource $resource)
    {
        $reactions = reactions()->index($resource);
        return response()->json($reactions,200);
    }
}
