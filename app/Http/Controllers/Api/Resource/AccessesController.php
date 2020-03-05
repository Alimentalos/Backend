<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\AccessesRequest;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/accesses",
     *      operationId="getResourceAccessesPaginated",
     *      tags={"Resources"},
     *      summary="Get resource accesses paginated.",
     *      description="Returns the resource accesses instances paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Resource accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implements has geofences trait"),
     * )
     * Get resource accesses paginated.
     *
     * @param AccessesRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, $resource)
    {
        $accesses = $resource
            ->accesses()
            ->with(['accessible', 'geofence', 'first_location', 'last_location'])
            ->latest()
            ->paginate(20);
        return response()->json($accesses, 200);
    }
}
