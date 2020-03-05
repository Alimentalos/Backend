<?php

namespace App\Http\Controllers\Api\Resource\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/users",
     *      operationId="getResourceUsersPaginated",
     *      tags={"Resources"},
     *      summary="Get resource users paginated.",
     *      description="Returns the resource users instances paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="resource",
     *          description="Resource class type",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource users retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Get resource users paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $users = $resource
            ->users()
            ->latest()
            ->with('photo', 'user')
            ->paginate(20);
        return response()->json($users,200);
    }
}
