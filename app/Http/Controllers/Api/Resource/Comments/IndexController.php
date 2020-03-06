<?php

namespace App\Http\Controllers\Api\Resource\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/pets/{pet}/comments",
     *      operationId="getPetComments",
     *      tags={"Pets"},
     *      summary="Get comments of pet.",
     *      description="Returns the comments of pet paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Comments retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/photos/{photo}/comments",
     *      operationId="getPhotoComments",
     *      tags={"Photos"},
     *      summary="Get comments of photo.",
     *      description="Returns the comments of photo paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Comments retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/comment/{comment}/comments",
     *      operationId="getCommentComments",
     *      tags={"Comments"},
     *      summary="Get comments of comment.",
     *      description="Returns the comments of comment paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Comments retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/alerts/{alert}/comments",
     *      operationId="getAlertComments",
     *      tags={"Alerts"},
     *      summary="Get comments of alert.",
     *      description="Returns the comments of alert paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Comments retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/groups/{groups}/comments",
     *      operationId="getGroupComments",
     *      tags={"Groups"},
     *      summary="Get comments of group.",
     *      description="Returns the comments of group paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="groups",
     *          description="Unique identifier of groups",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Comments retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource comments paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $comments = $resource->comments()->with('user')->latest()->paginate(20);
        return response()->json($comments,200);
    }
}
