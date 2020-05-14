<?php

namespace App\Http\Controllers\Api\Resource\Nested;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Alimentalos\Contracts\Resource;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/{uuid}/{nested}",
     *      operationId="getNestedResourcesOfResource",
     *      tags={"Resources", "Nested Resources"},
     *      summary="Get nested resources of resource.",
     *      description="Returns the nested resources of a resource paginated by a default quantity, payload includes pagination links and stats.",
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
     *               enum={"users", "groups"},
     *               default="users"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Nested resources retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get nested resources of resource paginated.
     *
     * @param IndexRequest $request
     * @param Resource $resource
     * @param Resource $nested
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Resource $resource, $nested)
    {
        if ($nested === 'reactions') {
            $nestedInstances = reactions()->index($resource);
        } else {
            $nestedInstances = $resource->{$nested}()->latest()->paginate(20);
            $nestedInstances->load(finder()->findClass($nested)->getLazyRelationshipsAttribute());
        }
        return response()->json($nestedInstances,200);
    }
}
