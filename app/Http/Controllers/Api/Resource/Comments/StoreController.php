<?php

namespace App\Http\Controllers\Api\Resource\Comments;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Comments\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/comments",
     *      operationId="createResourceComment",
     *      tags={"Resources"},
     *      summary="Create comment of resource.",
     *      description="Returns the recently created comment as JSON Object.",
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
        $comment = resourceComments()->create($resource);
        $comment->load((new Comment())->getLazyRelationshipsAttribute());
        return response()->json($comment,200);
    }
}
