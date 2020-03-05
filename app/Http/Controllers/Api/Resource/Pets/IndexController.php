<?php

namespace App\Http\Controllers\Api\Resource\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/pets",
     *      operationId="getResourcePetsPaginated",
     *      tags={"Resources"},
     *      summary="Get resource pets paginated.",
     *      description="Returns the resource pets instances paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Resource pets retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implemented has pets trait"),
     * )
     * Get resource pets paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $pets = $resource->pets()->latest()->with('photo', 'user')->paginate(20);
        return response()->json($pets,200);
    }
}
