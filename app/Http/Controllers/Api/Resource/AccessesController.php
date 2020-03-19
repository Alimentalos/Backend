<?php

namespace App\Http\Controllers\Api\Resource;

use Demency\Contracts\Resource;
use Demency\Relationships\Models\Access;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\AccessesRequest;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/{uuid}/accesses",
     *      operationId="getResourceAccesses",
     *      tags={"Resources"},
     *      summary="Get accesses of resource.",
     *      description="Returns the accesses paginated by a default quantity, payload includes pagination links and stats.",
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
     *               enum={"pets", "devices", "users"},
     *               default="pets"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Get resource accesses paginated.
     *
     * @param AccessesRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, Resource $resource)
    {
        $accesses = $resource
            ->accesses()
            ->latest()
            ->paginate(20);

        $accesses->load((new Access())->getLazyRelationshipsAttribute());
        return response()->json($accesses, 200);
    }
}
