<?php

namespace App\Http\Controllers\Api\Resource\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/{uuid}/comments",
     *      operationId="getResourceComments",
     *      tags={"Resources"},
     *      summary="Get comments of resource.",
     *      description="Returns the comments paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="uuid",
     *          description="Unique identifier of resource",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *         name="resource",
     *         in="path",
     *         description="Resource type that need to be considered",
     *         required=true,
     *         @OA\Schema(
     *         type="string",
     *           @OA\Items(
     *               type="string",
     *               enum={"pets", "photos", "comments", "alerts", "groups"},
     *               default="pets"
     *           ),
     *         )
     *     ),
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
