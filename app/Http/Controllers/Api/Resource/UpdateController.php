<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\UpdateRequest;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * @OA\Put(
     *      path="/photos/{photo}",
     *      operationId="updatePhoto",
     *      tags={"Photos"},
     *      summary="Update specific photo.",
     *      description="Returns the updated specified photo as JSON Object.",
     *      @OA\Parameter(
     *          name="photo",
     *          description="Unique identifier of photo",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Photo updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Photo not found"),
     *      @OA\Response(response=422, description="Unprocessable Entity")
     * )
     * @OA\Put(
     *      path="/alerts/{alert}",
     *      operationId="updateAlert",
     *      tags={"Alerts"},
     *      summary="Update specific alert.",
     *      description="Returns the updated specified alert as JSON Object.",
     *      @OA\Parameter(
     *          name="alert",
     *          description="Unique identifier of alert",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Alert updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Alert not found"),
     *      @OA\Response(response=422, description="Unprocessable Entity")
     * )
     * @OA\Put(
     *      path="/comments/{comment}",
     *      operationId="updateComment",
     *      tags={"Comments"},
     *      summary="Update specific comment.",
     *      description="Returns the updated specified comment as JSON Object.",
     *      @OA\Parameter(
     *          name="comment",
     *          description="Unique identifier of comment",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comment updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Comment not found"),
     *      @OA\Response(response=422, description="Unprocessable Entity")
     * )
     * @OA\Put(
     *      path="/users/{user}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update specific user.",
     *      description="Returns the updated specified user as JSON Object.",
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
     *          description="User updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="User not found"),
     *      @OA\Response(response=422, description="Unprocessable Entity")
     * )
     * @OA\Put(
     *      path="/devices/{device}",
     *      operationId="updateDevice",
     *      tags={"Devices"},
     *      summary="Update specific device.",
     *      description="Returns the updated specified device as JSON Object.",
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
     *          description="Device updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Device not found"),
     *      @OA\Response(response=422, description="Unprocessable Entity")
     * )
     * @OA\Put(
     *      path="/pets/{pet}",
     *      operationId="updatePet",
     *      tags={"Pets"},
     *      summary="Update specific pet.",
     *      description="Returns the updated specified pet as JSON Object.",
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
     *          description="Pet updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Pet not found"),
     *      @OA\Response(response=422, description="Unprocessable Entity")
     * )
     * @OA\Put(
     *      path="/groups/{group}",
     *      operationId="updateGroup",
     *      tags={"Groups"},
     *      summary="Update specific group.",
     *      description="Returns the updated specified group as JSON Object.",
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
     *          description="Group updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Group not found"),
     *      @OA\Response(response=422, description="Unprocessable Entity")
     * )
     * @OA\Put(
     *      path="/geofences/{geofence}",
     *      operationId="updateGeofence",
     *      tags={"Geofences"},
     *      summary="Update specific geofence.",
     *      description="Returns the updated specified geofence as JSON Object.",
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
     *          description="Geofence updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Geofence not found"),
     *      @OA\Response(response=422, description="Unprocessable Entity")
     * )
     * Update specific instance of resource.
     *
     * @param UpdateRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, $resource)
    {
        $payload = $resource->updateViaRequest();
        return response()->json($payload, 200);
    }
}
