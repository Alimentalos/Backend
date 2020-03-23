<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\DestroyRequest;
use Alimentalos\Contracts\Resource;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * @OA\Delete(
     *      path="/{resource}/{uuid}",
     *      operationId="destroyResource",
     *      tags={"Resources"},
     *      summary="Delete specific resource.",
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
     *               enum={"users", "photos", "comments", "actions", "devices", "pets", "geofences", "groups", "alerts"},
     *               default="devices"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Delete resource.
     *
     * @param DestroyRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, Resource $resource)
    {
        $resource->delete();
        return response()->json(['message' => 'Resource deleted successfully'],200);
    }
}
