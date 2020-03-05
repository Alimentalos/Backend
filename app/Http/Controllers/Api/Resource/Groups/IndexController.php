<?php

namespace App\Http\Controllers\Api\Resource\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/groups",
     *      operationId="getResourceGroupsPaginated",
     *      tags={"Resources"},
     *      summary="Get resource groups paginated.",
     *      description="Returns the resource groups instances paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Resource groups retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implements has groups trait"),
     * )
     * Get resource groups paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $groups = $resource->groups()->latest()->with('user', 'photo')->paginate(20);
        return response()->json($groups,200);
    }
}
