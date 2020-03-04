<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\ShowRequest;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/{uuid}",
     *      operationId="getResourceInstance",
     *      tags={"Resources"},
     *      summary="Get specific resource instance",
     *      description="Returns the specified resource instance as JSON Object",
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
     *          name="uuid",
     *          description="Unique universally identifier of specific Resource class instance",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource instance fetched successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     *
     * @param ShowRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, $resource)
    {
        $resource->load($resource->lazy_relationships);
        return response()->json($resource,200);
    }
}
