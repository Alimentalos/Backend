<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users/{user}/geofences",
     *      operationId="getUserGeofences",
     *      tags={"Users"},
     *      summary="Get geofences of user.",
     *      description="Returns the geofences of user paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Geofences retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/devices/{device}/geofences",
     *      operationId="getDeviceGeofences",
     *      tags={"Devices"},
     *      summary="Get geofences of device.",
     *      description="Returns the geofences of device paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Geofences retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/groups/{group}/geofences",
     *      operationId="getUserGeofences",
     *      tags={"Groups"},
     *      summary="Get geofences of group.",
     *      description="Returns the geofences of group paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Geofences retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/pets/{pet}/geofences",
     *      operationId="getPetGeofences",
     *      tags={"Pets"},
     *      summary="Get geofences of pet.",
     *      description="Returns the geofences of pet paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Geofences retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
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
