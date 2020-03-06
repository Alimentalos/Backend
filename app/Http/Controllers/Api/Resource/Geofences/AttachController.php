<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\AttachRequest;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/devices/{device}/geofences/{geofence}/attach",
     *      operationId="attachDeviceGeofence",
     *      tags={"Devices"},
     *      summary="Attach geofence to device.",
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
     *          description="Device attached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/users/{user}/geofences/{geofence}/attach",
     *      operationId="attachUserGeofence",
     *      tags={"Users"},
     *      summary="Attach geofence to user.",
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
     *          description="User attached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/groups/{group}/geofences/{geofence}/attach",
     *      operationId="attachGroupGeofence",
     *      tags={"Groups"},
     *      summary="Attach geofence to group.",
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
     *          description="Group attached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/pets/{pet}/geofences/{geofence}/attach",
     *      operationId="attachPetGeofence",
     *      tags={"Pets"},
     *      summary="Attach geofence to pet.",
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
     *          description="Pet attached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Attach geofence to resource.
     *
     * @param AttachRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, $resource, Geofence $geofence)
    {
        $resource->geofences()->attach($geofence->uuid);
        return response()->json([], 200);
    }
}
