<?php

namespace App\Http\Controllers\Resource\Geofences;

use App\Contracts\Resource;
use Alimentalos\Relationships\Models\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\Geofences\DetachRequest;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/geofences/{geofence}/detach",
     *      operationId="detachResourceGeofence",
     *      tags={"Resources"},
     *      summary="Detach geofence of resource.",
     *      description="Returns message JSON Object response.",
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
     *          description="Resource detached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Detach geofence to resource.
     *
     * @param DetachRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, Resource $resource, Geofence $geofence)
    {
        $resource->geofences()->detach($geofence->uuid);
        return response()->json(['message' => 'Resource detached geofence successfully'], 200);
    }
}
