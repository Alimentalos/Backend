<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}/search",
     *      operationId="searchResources",
     *      tags={"Resources"},
     *      summary="Search resources.",
     *      description="Returns the searched resources paginated by a default quantity, payload includes pagination links and stats.",
     *     @OA\Parameter(
     *         name="resource",
     *         in="path",
     *         description="Resource type that need to be considered",
     *         required=true,
     *         @OA\Schema(
     *         type="string",
     *           @OA\Items(
     *               type="string",
     *               enum={"users", "groups", "alerts", "devices", "geofences", "pets", "actions", "photos"},
     *               default="devices"
     *           ),
     *         )
     *     ),
     *     @OA\Parameter(
     *      name="q",
     *      description="The query concept",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *        type="string"
     *      )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Resources retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource paginated.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     * @codeCoverageIgnore
     */
    public function __invoke(IndexRequest $request)
    {
        $instances = $request->route('resource')->search(input('q'))->raw();
        return response()->json($instances, 200);
    }
}
