<?php

namespace App\Http\Controllers\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\Photos\DetachRequest;
use Alimentalos\Contracts\Resource;
use Alimentalos\Relationships\Models\Photo;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/photos/{photo}/detach",
     *      operationId="detachResourcePhoto",
     *      tags={"Resources"},
     *      summary="Detach photo of resource.",
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
     *               enum={"pets", "users", "geofences", "groups", "places"},
     *               default="pets"
     *           ),
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="photo",
     *          description="Unique identifier of photo",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource detached to photo successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Detach group to resource.
     *
     * @param DetachRequest $request
     * @param Resource $resource
     * @param Photo $photo
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, Resource $resource, Photo $photo)
    {
        $resource->photos()->detach($photo->uuid);
        return response()->json(['message' => 'Resource detached to photo successfully'], 200);
    }
}
