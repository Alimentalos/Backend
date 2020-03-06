<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\DetachRequest;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/devices/{device}/geofences/{geofence}/detach",
     *      operationId="detachDeviceGeofence",
     *      tags={"Devices"},
     *      summary="Detach geofence of device.",
     *      description="Returns empty array as JSON response.",
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
     *          description="Device detached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/users/{user}/geofences/{geofence}/detach",
     *      operationId="detachUserGeofence",
     *      tags={"Users"},
     *      summary="Detach geofence of user.",
     *      description="Returns empty array as JSON response.",
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
     *          description="User detached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/groups/{group}/geofences/{geofence}/detach",
     *      operationId="detachGroupGeofence",
     *      tags={"Groups"},
     *      summary="Detach geofence of group.",
     *      description="Returns empty array as JSON response.",
     *      @OA\Parameter(
     *          name="group",
     *          description="Unique identifier of group",
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
     *          description="Group detached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/pets/{pet}/geofences/{geofence}/detach",
     *      operationId="detachPetGeofence",
     *      tags={"Pets"},
     *      summary="Detach geofence of pet.",
     *      description="Returns empty array as JSON response.",
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
     *          description="Pet detached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Detach geofence to resource.
     *
     * @param DetachRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, $resource, Geofence $geofence)
    {
        $resource->geofences()->detach($geofence->uuid);
        return response()->json([], 200);
    }
}
