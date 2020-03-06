<?php

namespace App\Http\Controllers\Api\Resource\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Comments\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @OA\Post(
     *      path="/pets/{pet}/comments",
     *      operationId="createPetComment",
     *      tags={"Pets"},
     *      summary="Create comment of pet.",
     *      description="Returns the recently created comment instance as JSON Object.",
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
     *          description="Comment created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/photos/{photo}/comments",
     *      operationId="createPhotoComment",
     *      tags={"Photos"},
     *      summary="Create comment of photo.",
     *      description="Returns the recently created comment instance as JSON Object.",
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
     *          description="Comment created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/comments/{comment}/comments",
     *      operationId="createCommentComment",
     *      tags={"Comments"},
     *      summary="Create comment of comment.",
     *      description="Returns the recently created comment instance as JSON Object.",
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
     *          description="Comment created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/alerts/{alert}/comments",
     *      operationId="createAlertComment",
     *      tags={"Alerts"},
     *      summary="Create comment of alert.",
     *      description="Returns the recently created comment instance as JSON Object.",
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
     *          description="Comment created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/groups/{group}/comments",
     *      operationId="createGroupComment",
     *      tags={"Groups"},
     *      summary="Create comment of group.",
     *      description="Returns the recently created comment instance as JSON Object.",
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
     *          description="Comment created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Create resource comments.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        $comment = resourceComments()->createViaRequest($resource);
        return response()->json($comment,200);
    }
}
