<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Photos\AttachRequest;
use Demency\Contracts\Resource;
use Demency\Relationships\Models\Photo;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/groups/{group}/attach",
     *      operationId="attachResourcePhoto",
     *      tags={"Resources"},
     *      summary="Attach photo of resource.",
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
     *          name="group",
     *          description="Unique identifier of group",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource attached to photo successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Attach group to resource.
     *
     * @param AttachRequest $request
     * @param Resource $resource
     * @param Photo $photo
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, Resource $resource, Photo $photo)
    {
        $resource->photos()->attach($photo->uuid);
        return response()->json(['message' => 'Resource attached to photo successfully'], 200);
    }
}
