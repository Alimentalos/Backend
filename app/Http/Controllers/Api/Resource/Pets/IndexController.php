<?php

namespace App\Http\Controllers\Api\Resource\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/groups/{group}/pets",
     *      operationId="getGroupPets",
     *      tags={"Groups"},
     *      summary="Get pets of group.",
     *      description="Returns the pets of group paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Pets retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/users/{user}/pets",
     *      operationId="getUserPets",
     *      tags={"Users"},
     *      summary="Get pets of user.",
     *      description="Returns the pets of user paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Pets retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
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
