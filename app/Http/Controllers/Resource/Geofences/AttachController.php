<?php

namespace App\Http\Controllers\Resource\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\AttachRequest;
use Alimentalos\Contracts\Resource;
use Alimentalos\Relationships\Models\Geofence;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/geofences/{geofence}/attach",
     *      operationId="attachResourceGeofence",
     *      tags={"Resources"},
     *      summary="Attach geofence to resource.",
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
     *          description="Resource attached to geofence successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Attach geofence to resource.
     *
     * @param AttachRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, Resource $resource, Geofence $geofence)
    {
        $resource->geofences()->attach($geofence->uuid);
        return response()->json(['message' => 'Resource attached to geofence successfully'], 200);
    }
}
