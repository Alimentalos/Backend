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
     *      path="/users/{user}/groups/{group}/detach",
     *      operationId="detachUserGroup",
     *      tags={"Users"},
     *      summary="Detach group of user.",
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
     *          description="User detached to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/pets/{pet}/groups/{group}/detach",
     *      operationId="detachPetGroup",
     *      tags={"Pets"},
     *      summary="Detach group of pet.",
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
     *          description="Pet detached to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/devices/{device}/groups/{group}/detach",
     *      operationId="detachPetGroup",
     *      tags={"Devices"},
     *      summary="Detach group of device.",
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
     *          description="Device detached to group successfully"
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
    public function __invoke(DetachRequest $request, $resource, Group $group)
    {
        $resource->groups()->detach($group->uuid);
        return response()->json([], 200);
    }
}
