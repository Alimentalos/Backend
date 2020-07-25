<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\UpdateRequest;
use Alimentalos\Contracts\Resource;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * @OA\Put(
     *      path="/{resource}/{uuid}",
     *      operationId="updateResource",
     *      tags={"Resources"},
     *      summary="Update specific resource.",
     *      description="Returns the updated resource as JSON Object.",
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
     *               enum={"photos", "alerts", "comments", "users", "devices", "pets", "groups", "geofences"},
     *               default="devices"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource not found"),
     *      @OA\Response(response=422, description="Unprocessable entity")
     * )
     * Update specific instance of resource.
     *
     * @param UpdateRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Resource $resource)
    {
        $payload = $resource->updateViaRequest();
        $payload->load($payload->lazy_relationships);
        return response()->json($payload, 200);
    }
}
