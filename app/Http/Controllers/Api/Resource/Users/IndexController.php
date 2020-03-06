<?php

namespace App\Http\Controllers\Api\Resource\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/geofences/{geofence}/users",
     *      operationId="getGeofenceUsers",
     *      tags={"Geofences"},
     *      summary="Get users of geofence.",
     *      description="Returns the geofence users instances paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="geofence",
     *          description="Unique identifier of geofence",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Geofence users retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Get(
     *      path="/groups/{group}/users",
     *      operationId="getGroupUsers",
     *      tags={"Groups"},
     *      summary="Get users of group.",
     *      description="Returns the group users instances paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="group",
     *          description="Unique identifier of group",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Group users retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Get resource users paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $users = $resource
            ->users()
            ->latest()
            ->with('photo', 'user')
            ->paginate(20);
        return response()->json($users,200);
    }
}
