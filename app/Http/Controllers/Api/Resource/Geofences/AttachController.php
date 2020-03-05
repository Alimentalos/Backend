<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\AttachRequest;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/geofence/{geofence}/attach",
     *      operationId="attachResourceGeofenceInstance",
     *      tags={"Resources"},
     *      summary="Attach geofence to resource instance.",
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
     *          description="Resource instance attached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implements has geofences trait"),
     * )
     * Attach geofence to resource instance.
     *
     * @param AttachRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, $resource, Geofence $geofence)
    {
        $resource->geofences()->attach($geofence->uuid);
        return response()->json([], 200);
    }
}
