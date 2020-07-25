<?php

namespace App\Http\Controllers\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\Photos\StoreRequest;
use Alimentalos\Contracts\Resource;
use Alimentalos\Relationships\Models\Photo;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/photos",
     *      operationId="createResourcePhoto",
     *      tags={"Resources"},
     *      summary="Create photo of resource.",
     *      description="Returns the recently created photo as JSON Object.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Photo created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Create resource photo.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, Resource $resource)
    {
        $photo = resourcePhotos()->create($resource);
        $photo->load((new Photo())->getLazyRelationshipsAttribute());
        return response()->json($photo,200);
    }
}
