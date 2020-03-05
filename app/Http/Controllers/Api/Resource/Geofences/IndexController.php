<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/geofences",
     *      operationId="getResourceGeofencesPaginated",
     *      tags={"Resources"},
     *      summary="Get resource geofences paginated.",
     *      description="Returns the resource geofences instances paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Resource geofences retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implements has geofences trait"),
     * )
     * Get resource geofences paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $geofences = $resource->geofences()->latest()->with('user', 'photo')->paginate(20);
        return response()->json($geofences,200);
    }
}
