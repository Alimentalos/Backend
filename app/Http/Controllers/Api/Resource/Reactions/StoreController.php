<?php

namespace App\Http\Controllers\Api\Resource\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Reactions\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @OA\Post(
     *      path="/geofences/{geofence}/reactions",
     *      operationId="storeGeofenceReaction",
     *      tags={"Geofences"},
     *      summary="Create reaction of geofence.",
     *      description="Returns the empty array as JSON response.",
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
     *          description="Geofence reaction created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/pets/{pet}/reactions",
     *      operationId="storePetReaction",
     *      tags={"Pets"},
     *      summary="Create reaction of pet.",
     *      description="Returns the empty array as JSON response.",
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
     *          description="Pet reaction created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/users/{user}/reactions",
     *      operationId="storeUserReaction",
     *      tags={"Users"},
     *      summary="Create reaction of user.",
     *      description="Returns the empty array as JSON response.",
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
     *          description="User reaction created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/photos/{photo}/reactions",
     *      operationId="storePhotoReaction",
     *      tags={"Photos"},
     *      summary="Create reaction of photo.",
     *      description="Returns the empty array as JSON response.",
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
     *          description="Photo reaction created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/comments/{comment}/reactions",
     *      operationId="storeCommentReaction",
     *      tags={"Comments"},
     *      summary="Create reaction of comment.",
     *      description="Returns the empty array as JSON response.",
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
     *          description="Comment reaction created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Create resource reaction.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        likes()->updateLike($resource->getLoveReactant(), authenticated()->getLoveReacter(), input('type'));
        return response()->json([],200);
    }
}
