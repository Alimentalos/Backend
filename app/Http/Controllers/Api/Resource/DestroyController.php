<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * @OA\Delete(
     *      path="/users/{user}",
     *      operationId="destroyUser",
     *      tags={"Users"},
     *      summary="Delete specific user.",
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
     *      @OA\Response(
     *          response=200,
     *          description="User deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Delete(
     *      path="/photos/{photo}",
     *      operationId="destroyPhoto",
     *      tags={"Photos"},
     *      summary="Delete specific photo.",
     *      description="Returns empty array as JSON response.",
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
     *          description="Photo deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Delete(
     *      path="/comments/{comment}",
     *      operationId="destroyComment",
     *      tags={"Comments"},
     *      summary="Delete specific comment.",
     *      description="Returns empty array as JSON response.",
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
     *          description="Comment deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Delete(
     *      path="/actions/{action}",
     *      operationId="destroyAction",
     *      tags={"Actions"},
     *      summary="Delete specific action.",
     *      description="Returns empty array as JSON response.",
     *      @OA\Parameter(
     *          name="action",
     *          description="Unique identifier of action",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Action deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Delete(
     *      path="/devices/{device}",
     *      operationId="destroyDevice",
     *      tags={"Devices"},
     *      summary="Delete specific device.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Device deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Delete(
     *      path="/pets/{pet}",
     *      operationId="destroyPet",
     *      tags={"Pets"},
     *      summary="Delete specific pet.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Pet deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Delete(
     *      path="/geofences/{geofence}",
     *      operationId="destroyGeofence",
     *      tags={"Geofences"},
     *      summary="Delete specific geofence.",
     *      description="Returns empty array as JSON response.",
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
     *          description="Geofence deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Delete(
     *      path="/groups/{group}",
     *      operationId="destroyGroup",
     *      tags={"Groups"},
     *      summary="Delete specific group.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Group deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Delete(
     *      path="/alerts/{alert}",
     *      operationId="destroyAlert",
     *      tags={"Alerts"},
     *      summary="Delete specific alert.",
     *      description="Returns empty array as JSON response.",
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
     *          description="Alert deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Delete resource.
     *
     * @param DestroyRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, $resource)
    {
        try {
            $resource->delete();

            return response()->json(['message' => 'Deleted successfully.'],200);
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return response()->json(
                ['message' => 'Resource cannot be deleted.'],
                500
            );
        }
        // @codeCoverageIgnoreEnd
    }
}
