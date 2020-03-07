<?php

namespace App\Http\Controllers\Api\Resource\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Groups\AttachRequest;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/groups/{group}/attach",
     *      operationId="attachResourceGroup",
     *      tags={"Resources"},
     *      summary="Attach group of resource.",
     *      description="Returns empty array as JSON response.",
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
     *               enum={"users", "pets", "devices"},
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
     *          description="Resource attached to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Attach group to resource.
     *
     * @param AttachRequest $request
     * @param $resource
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, $resource, Group $group)
    {
        $resource->groups()
            ->attach($group->uuid,[
                'status' => Group::ATTACHED_STATUS,
                'is_admin' => fill( 'is_admin', false)
            ]);
        return response()->json([], 200);
    }
}
