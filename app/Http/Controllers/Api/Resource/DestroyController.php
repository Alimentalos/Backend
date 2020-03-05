<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * @OA\Delete(
     *      path="/{resource}",
     *      operationId="destroyResourceInstance",
     *      tags={"Resources"},
     *      summary="Delete resource instance.",
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
     *      @OA\Response(
     *          response=200,
     *          description="Resource instance deleted successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Delete resource instance.
     *
     * @param DestroyRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, $resource)
    {
        try {
            $resource->delete();

            return response()->json(['message' => 'Deleted successfully.'],200);
            // @codeCoverageIgnoreStart
        } catch (Exception $exception) {
            return response()->json(
                ['message' => 'Resource cannot be deleted.'],
                500
            );
        }
        // @codeCoverageIgnoreEnd
    }
}
