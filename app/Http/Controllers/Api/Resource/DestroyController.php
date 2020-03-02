<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, $resource)
    {
        try {
            $resource->delete();

            return response()->json(
                ['message' => 'Deleted successfully.'],
                200
            );
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
