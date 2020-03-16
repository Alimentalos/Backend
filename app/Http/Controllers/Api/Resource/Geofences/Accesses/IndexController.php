<?php

namespace App\Http\Controllers\Api\Resource\Geofences\Accesses;

use Demency\Relationships\Models\Access;
use Demency\Relationships\Models\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\Accesses\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/{uuid}/geofences/{geofence}/accesses",
     *      operationId="getResourceGeofenceAccesses",
     *      tags={"Resources"},
     *      summary="Get accesses of resource related to geofence.",
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
     *               enum={"devices", "users", "pets"},
     *               default="devices"
     *           ),
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="geofence",
     *          description="Unique identifier of geofence",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource specific geofence accesses paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource, Geofence $geofence)
    {
        $accesses = $resource
            ->accesses()
            ->where([['geofence_uuid', $geofence->uuid]])
            ->latest()
            ->paginate(20);

        $accesses->load((new Access())->getLazyRelationshipsAttribute());
        return response()->json($accesses,200);
    }
}
