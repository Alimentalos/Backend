<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\ShowRequest;
use Demency\Contracts\Resource;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/{uuid}",
     *      operationId="getResource",
     *      tags={"Resources"},
     *      summary="Get specific resource.",
     *      description="Returns the specified resource as JSON Object.",
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
     *               enum={"users", "devices", "groups", "pets", "actions", "locations", "geofences", "photos", "comments", "alerts"},
     *               default="devices"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource not found")
     * )
     * Get specific instance of resource.
     *
     * @param ShowRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, Resource $resource)
    {
        $resource->load($resource->lazy_relationships);
        return response()->json($resource,200);
    }
}
