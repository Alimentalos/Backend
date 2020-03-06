<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users/{user}/reactions",
     *      operationId="getUserReactions",
     *      tags={"Users"},
     *      summary="Get reactions stats of user.",
     *      description="Returns the user reactions stats.",
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
     *          description="User reactions retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Get(
     *      path="/geofences/{geofence}/reactions",
     *      operationId="getGeofenceReactions",
     *      tags={"Geofences"},
     *      summary="Get reactions stats of geofence.",
     *      description="Returns the geofence reactions stats.",
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
     *          description="User reactions retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Get(
     *      path="/pets/{pet}/reactions",
     *      operationId="getPetReactions",
     *      tags={"Pets"},
     *      summary="Get reactions stats of pet.",
     *      description="Returns the pet reactions stats.",
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
     *          description="Pet reactions retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Get(
     *      path="/photos/{photo}/reactions",
     *      operationId="getPhotoReactions",
     *      tags={"Photos"},
     *      summary="Get reactions stats of photo.",
     *      description="Returns the photo reactions stats.",
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
     *          description="Photo reactions retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Get(
     *      path="/comments/{comment}/reactions",
     *      operationId="getCommentReactions",
     *      tags={"Comments"},
     *      summary="Get reactions stats of comment.",
     *      description="Returns the comment reactions stats.",
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
     *          description="Comment reactions retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Get resource reactions stats.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $reactions = reactions()->fetchViaRequest($resource);
        return response()->json($reactions,200);
    }
}
