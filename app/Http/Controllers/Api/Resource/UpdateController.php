<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\UpdateRequest;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * @OA\Put(
     *      path="/{resource}/{uuid}",
     *      operationId="updateResourceInstance",
     *      tags={"Resources"},
     *      summary="Update specific instance of resource.",
     *      description="Returns the updated specified resource instance identified by UUID as JSON Object.",
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
     *          name="uuid",
     *          description="Unique universally identifier of specific Resource class instance",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource instance updated and retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     * Update specific instance of resource.
     *
     * @param UpdateRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, $resource)
    {
        $payload = $resource->updateViaRequest();
        return response()->json($payload, 200);
    }
}
