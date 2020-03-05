<?php

namespace App\Http\Controllers\Api\Resource\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Groups\DetachRequest;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/groups/{group}/detach",
     *      operationId="detachResourceGroupInstance",
     *      tags={"Resources"},
     *      summary="Detach group to resource instance.",
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
     *          name="group",
     *          description="Group identifier",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource instance detached to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implements has groups trait"),
     * )
     * Detach group to resource instance.
     *
     * @param DetachRequest $request
     * @param $resource
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, $resource, Group $group)
    {
        $resource->groups()->detach($group->uuid);
        return response()->json([], 200);
    }
}
