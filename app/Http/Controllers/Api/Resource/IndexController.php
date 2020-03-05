<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}",
     *      operationId="getResourcePaginated",
     *      tags={"Resources"},
     *      summary="Get resource paginated.",
     *      description="Returns the resource instances paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Resources retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Get resource paginated.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        $instances = resource()->getInstances();
        return response()->json($instances, 200);
    }
}
