<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Demency\Contracts\Resource;
use Demency\Relationships\Models\Photo;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/{uuid}/photos",
     *      operationId="getResourcePhotos",
     *      tags={"Resources"},
     *      summary="Get photos of resource.",
     *      description="Returns the photos paginated by a default quantity, payload includes pagination links and stats.",
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
     *               enum={"pets", "users", "geofences", "groups"},
     *               default="users"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Photos retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource photos paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Resource $resource)
    {
        $photos = $resource->photos()->latest()->paginate(20);
        $photos->load((new Photo())->getLazyRelationshipsAttribute());
        return response()->json($photos,200);
    }
}
