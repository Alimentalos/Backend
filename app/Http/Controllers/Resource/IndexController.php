<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/{resource}",
     *      operationId="getResources",
     *      tags={"Resources"},
     *      summary="Get resources.",
     *      description="Returns the resources paginated by a default quantity, payload includes pagination links and stats.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Resources retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource paginated.
     *
     * @param IndexRequest $request
     * @return JsonResponse|View
     */
    public function __invoke(IndexRequest $request)
    {
        $instances = resource()->getInstances();
        $instances->load(resource()->getLazyRelationshipsAttribute());
        return $request->wantsJson() ?
			response()->json($instances, 200) :
			view(finder()->currentResource() . '.index')->with(['instances' => $instances]);
    }
}
