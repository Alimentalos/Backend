<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/",
     *      operationId="getResourceList",
     *      tags={"Resources"},
     *      summary="Get resource paginated instance list",
     *      description="Returns the resource list paginated by a default quantity, payload includes pagination links and stats",
     *      @OA\Parameter(
     *          name="resource",
     *          description="Resource class type",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource list fetched successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        return response()->json(finder()->findClass(finder()->currentResource())->getInstances($request), 200);
    }
}
