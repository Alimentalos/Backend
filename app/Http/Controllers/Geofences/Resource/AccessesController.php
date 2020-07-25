<?php

namespace App\Http\Controllers\Geofences\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Geofences\Resource\AccessesRequest;
use Alimentalos\Contracts\Resource;
use Alimentalos\Relationships\Models\Access;
use Alimentalos\Relationships\Models\Geofence;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/geofences/{uuid}/{type}/accesses",
     *      operationId="getGeofenceResourcesAccesses",
     *      tags={"Geofences"},
     *      summary="Get geofence accesses of resource.",
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
     *         name="type",
     *         in="path",
     *         description="Resource type that need to be considered",
     *         required=true,
     *         @OA\Schema(
     *         type="string",
     *           @OA\Items(
     *               type="string",
     *               enum={"users", "devices", "pets"},
     *               default="pets"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Geofence accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Retrieve paginated resource access of geofences.
     *
     * @param AccessesRequest $request
     * @param Geofence $geofence
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, Geofence $geofence, Resource $resource)
    {
        $accesses = geofencesAccesses()->index($geofence, $resource);
        $accesses->load((new Access())->getLazyRelationshipsAttribute());
        return response()->json($accesses,200);
    }
}
