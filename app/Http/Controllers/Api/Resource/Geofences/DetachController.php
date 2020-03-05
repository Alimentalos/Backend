<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\DetachRequest;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/geofence/{geofence}/detach",
     *      operationId="detachResourceGeofenceInstance",
     *      tags={"Resources"},
     *      summary="Detach geofence to resource instance.",
     *      description="Returns empty array as JSON response.",
     *      @OA\Parameter(
     *          name="resource",
     *          description="Resource class type",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="geofence",
     *          description="Geofence identifier",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource instance detached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implements has geofences trait"),
     * )
     * Detach geofence to resource instance.
     *
     * @param DetachRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, $resource, Geofence $geofence)
    {
        $resource->geofences()->detach($geofence->uuid);
        return response()->json([], 200);
    }
}
