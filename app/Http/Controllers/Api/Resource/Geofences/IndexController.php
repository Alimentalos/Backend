<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/{uuid}/geofences",
     *      operationId="getResourceGeofences",
     *      tags={"Resources"},
     *      summary="Get geofences of resource.",
     *      description="Returns the geofences paginated by a default quantity, payload includes pagination links and stats.",
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
     *               enum={"devices", "users", "groups", "pets"},
     *               default="devices"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Geofences retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource geofences paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $geofences = $resource->geofences()->latest()->with('user', 'photo')->paginate(20);
        return response()->json($geofences,200);
    }
}
