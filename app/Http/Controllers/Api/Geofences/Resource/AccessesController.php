<?php

namespace App\Http\Controllers\Api\Geofences\Resource;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\Resource\AccessesRequest;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/geofences/{geofence}/users/accesses",
     *      operationId="getGeofenceUsersAccesses",
     *      tags={"Geofences"},
     *      summary="Get geofence accesses of users.",
     *      description="Returns the geofence accesses of users paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Geofence accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/geofences/{geofence}/devices/accesses",
     *      operationId="getGeofenceDevicesAccesses",
     *      tags={"Geofences"},
     *      summary="Get geofence accesses of devices.",
     *      description="Returns the geofence accesses of devices paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Geofence accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/geofences/{geofence}/pets/accesses",
     *      operationId="getGeofencePetsAccesses",
     *      tags={"Geofences"},
     *      summary="Get geofence accesses of pets.",
     *      description="Returns the geofence accesses of pets paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Geofence accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Retrieve paginated resource access of geofences.
     *
     * @param AccessesRequest $request
     * @param Geofence $geofence
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, Geofence $geofence, $resource)
    {
        $accesses = geofencesAccesses()->index($geofence, $resource);
        return response()->json($accesses,200);
    }
}
