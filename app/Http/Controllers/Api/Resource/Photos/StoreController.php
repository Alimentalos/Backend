<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Photos\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @OA\Post(
     *      path="/users/{user}/photos",
     *      operationId="createUserPhoto",
     *      tags={"Users"},
     *      summary="Create photo of user.",
     *      description="Returns the recently created photo as JSON Object.",
     *      @OA\Parameter(
     *          name="user",
     *          description="Unique identifier of user",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Photo created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/groups/{group}/photos",
     *      operationId="createGroupPhoto",
     *      tags={"Groups"},
     *      summary="Create photo of group.",
     *      description="Returns the recently created photo as JSON Object.",
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
     *          description="Photo created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/geofences/{geofence}/photos",
     *      operationId="createGeofencePhoto",
     *      tags={"Groups"},
     *      summary="Create photo of geofence.",
     *      description="Returns the recently created photo as JSON Object.",
     *      @OA\Parameter(
     *          name="geofence",
     *          description="Unique identifier of geofence",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Photo created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Post(
     *      path="/pets/{pet}/photos",
     *      operationId="createPetPhoto",
     *      tags={"Pets"},
     *      summary="Create photo of pet.",
     *      description="Returns the recently created photo as JSON Object.",
     *      @OA\Parameter(
     *          name="pet",
     *          description="Unique identifier of pet",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
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
    public function __invoke(StoreRequest $request, $resource)
    {
        $photo = resourcePhotos()->createViaRequest($resource);
        return response()->json($photo,200);
    }
}
