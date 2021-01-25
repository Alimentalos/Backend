<?php

namespace App\Http\Controllers\Resource\Reactions;

use App\Contracts\Resource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\Reactions\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/reactions",
     *      operationId="storeResourceReaction",
     *      tags={"Resources"},
     *      summary="Create reaction of resource.",
     *      description="Returns the empty array as JSON response.",
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
     *               enum={"geofences", "pets", "users", "photos", "comments"},
     *               default="users"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource reaction created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Create resource reaction.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, Resource $resource)
    {
        likes()->update($resource->getLoveReactant(), authenticated()->getLoveReacter(), input('type'));
        return response()->json([],200);
    }
}
