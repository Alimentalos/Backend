<?php

namespace App\Http\Controllers\Resource\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Groups\DetachRequest;
use Alimentalos\Contracts\Resource;
use Alimentalos\Relationships\Models\Group;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/groups/{group}/detach",
     *      operationId="detachResourceGroup",
     *      tags={"Resources"},
     *      summary="Detach group of resource.",
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
     *               enum={"geofences", "pets", "devices", "users"},
     *               default="devices"
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
     *          description="Resource detached to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Detach group to resource.
     *
     * @param DetachRequest $request
     * @param $resource
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, Resource $resource, Group $group)
    {
        $resource->groups()->detach($group->uuid);
        return response()->json(['message' => 'Resource detached to group successfully'], 200);
    }
}
