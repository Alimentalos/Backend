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
     *      path="/users/{user}/groups/{group}/attach",
     *      operationId="attachUserGroup",
     *      tags={"Users"},
     *      summary="Attach group of user.",
     *      description="Returns empty array as JSON response.",
     *      @OA\Parameter(
     *          name="user",
     *          description="Unique identifier of user",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
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
     *          description="User attached to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/pets/{pet}/groups/{group}/attach",
     *      operationId="attachPetGroup",
     *      tags={"Pets"},
     *      summary="Attach group of pet.",
     *      description="Returns empty array as JSON response.",
     *      @OA\Parameter(
     *          name="pet",
     *          description="Unique identifier of pet",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
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
     *          description="Pet attached to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/devices/{device}/groups/{group}/attach",
     *      operationId="attachPetGroup",
     *      tags={"Devices"},
     *      summary="Attach group of device.",
     *      description="Returns empty array as JSON response.",
     *      @OA\Parameter(
     *          name="device",
     *          description="Unique identifier of device",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
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
     *          description="Device attached to group successfully"
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
