<?php

namespace App\Http\Controllers\Api\Resource\Geofences\Accesses;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\Accesses\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/pets/{pet}/geofences/{geofence}/accesses",
     *      operationId="getPetGeofenceAccesses",
     *      tags={"Pets"},
     *      summary="Get accesses of pet related to geofence.",
     *      description="Returns the accesses paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="pet",
     *          description="Unique identifier of pet",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
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
     *          description="Accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/devices/{device}/geofences/{geofence}/accesses",
     *      operationId="getDeviceGeofenceAccesses",
     *      tags={"Devices"},
     *      summary="Get accesses of device related to geofence.",
     *      description="Returns the accesses paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="device",
     *          description="Unique identifier of device",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
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
     *          description="Accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/users/{user}/geofences/{geofence}/accesses",
     *      operationId="getUserGeofenceAccesses",
     *      tags={"Users"},
     *      summary="Get accesses of user related to geofence.",
     *      description="Returns the accesses paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="user",
     *          description="Unique identifier of user",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
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
     *          description="Accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource specific geofence accesses paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource, Geofence $geofence)
    {
        $accesses = $resource
            ->accesses()
            ->with(['accessible', 'geofence', 'first_location', 'last_location'])
            ->where([['geofence_uuid', $geofence->uuid]])
            ->latest()
            ->paginate(20);
        return response()->json($accesses,200);
    }
}
