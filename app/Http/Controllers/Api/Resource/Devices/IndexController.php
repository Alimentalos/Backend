<?php

namespace App\Http\Controllers\Api\Resource\Devices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/devices",
     *      operationId="getResourceDevicesPaginated",
     *      tags={"Resources"},
     *      summary="Get resource devices paginated.",
     *      description="Returns the resource devices instances paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Resource devices retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implements has devices trait"),
     * )
     * Get resource devices paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $devices = $resource->devices()->latest()->with('user')->paginate(20);
        return response()->json($devices,200);
    }
}
