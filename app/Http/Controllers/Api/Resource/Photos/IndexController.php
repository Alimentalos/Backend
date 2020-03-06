<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/pets/{pet}/photos",
     *      operationId="getPetPhotos",
     *      tags={"Pets"},
     *      summary="Get photos of user.",
     *      description="Returns the pet photos paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Photos retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/geofences/{geofence}/photos",
     *      operationId="getGeofencePhotos",
     *      tags={"Geofences"},
     *      summary="Get photos of geofence.",
     *      description="Returns the geofence photos paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Photos retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/users/{user}/photos",
     *      operationId="getUserPhotos",
     *      tags={"Users"},
     *      summary="Get photos of user.",
     *      description="Returns the user photos paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Photos retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/groups/{group}/photos",
     *      operationId="getGroupPhotos",
     *      tags={"Groups"},
     *      summary="Get photos of group.",
     *      description="Returns the group photos paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Photos retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource photos paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $photos = $resource->photos()->latest()->with('user', 'comment')->paginate(20);
        return response()->json($photos,200);
    }
}
