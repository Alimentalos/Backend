<?php

namespace App\Http\Controllers\Api\Resource\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/geofences/{geofence}/groups",
     *      operationId="getGeofenceGroups",
     *      tags={"Geofences"},
     *      summary="Get groups of geofence.",
     *      description="Returns the groups of geofence paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Groups retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/pets/{pet}/groups",
     *      operationId="getPetGroups",
     *      tags={"Pets"},
     *      summary="Get groups of pet.",
     *      description="Returns the groups of pet paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="pet",
     *          description="Unique identifier of pet",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Groups retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/devices/{device}/groups",
     *      operationId="getDeviceGroups",
     *      tags={"Devices"},
     *      summary="Get groups of device.",
     *      description="Returns the groups of device paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="device",
     *          description="Unique identifier of device",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Groups retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/users/{user}/groups",
     *      operationId="getUserGroups",
     *      tags={"Users"},
     *      summary="Get groups of user.",
     *      description="Returns the groups of user paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="user",
     *          description="Unique identifier of user",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Groups retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
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
