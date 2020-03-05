<?php

namespace App\Http\Controllers\Api\Near\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Near\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/near/{resource}",
     *      operationId="getNearResourcesPaginated",
     *      tags={"Resources"},
     *      summary="Get near resources paginated.",
     *      description="Returns the near located resource instances paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Resource retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implements has location trait")
     * )
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
