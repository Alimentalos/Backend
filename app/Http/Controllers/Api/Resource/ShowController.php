<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\ShowRequest;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users/{user}",
     *      operationId="getUser",
     *      tags={"Users"},
     *      summary="Get specific user.",
     *      description="Returns the specified user as JSON Object.",
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
     *          description="User retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="User not found")
     * )
     * @OA\Get(
     *      path="/devices/{device}",
     *      operationId="getUser",
     *      tags={"Devices"},
     *      summary="Get specific device.",
     *      description="Returns the specified device as JSON Object.",
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
     *          description="Device retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Device not found")
     * )
     * @OA\Get(
     *      path="/groups/{group}",
     *      operationId="getGroup",
     *      tags={"Groups"},
     *      summary="Get specific group.",
     *      description="Returns the specified group as JSON Object.",
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
     *          description="Group retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Group not found")
     * )
     * @OA\Get(
     *      path="/pets/{pet}",
     *      operationId="getPet",
     *      tags={"Pets"},
     *      summary="Get specific pet.",
     *      description="Returns the specified pet as JSON Object.",
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
     *          description="Pet retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Pet not found")
     * )
     * @OA\Get(
     *      path="/actions/{action}",
     *      operationId="getAction",
     *      tags={"Actions"},
     *      summary="Get specific action.",
     *      description="Returns the specified action as JSON Object.",
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
     *          description="Action retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Action not found")
     * )
     * @OA\Get(
     *      path="/locations/{location}",
     *      operationId="getLocation",
     *      tags={"Locations"},
     *      summary="Get specific location.",
     *      description="Returns the specified location as JSON Object.",
     *      @OA\Parameter(
     *          name="location",
     *          description="Unique identifier of location",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Location retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Location not found")
     * )
     * @OA\Get(
     *      path="/geofences/{geofence}",
     *      operationId="getGeofence",
     *      tags={"Geofences"},
     *      summary="Get specific geofence.",
     *      description="Returns the specified geofence as JSON Object.",
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
     *          description="Geofence retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Geofence not found")
     * )
     * @OA\Get(
     *      path="/photos/{photo}",
     *      operationId="getPhoto",
     *      tags={"Photos"},
     *      summary="Get specific photo.",
     *      description="Returns the specified photo as JSON Object.",
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
     *          description="Photo retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Photo not found")
     * )
     * @OA\Get(
     *      path="/comments/{comment}",
     *      operationId="getComment",
     *      tags={"Comments"},
     *      summary="Get specific comment.",
     *      description="Returns the specified comment as JSON Object.",
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
     *          description="Comment retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Comment not found")
     * )
     * @OA\Get(
     *      path="/alerts/{alert}",
     *      operationId="getAlert",
     *      tags={"Alerts"},
     *      summary="Get specific alert.",
     *      description="Returns the specified alert as JSON Object.",
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
     *          description="Alert retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Alert not found")
     * )
     * Get specific instance of resource.
     *
     * @param ShowRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, $resource)
    {
        $resource->load($resource->lazy_relationships);
        return response()->json($resource,200);
    }
}
