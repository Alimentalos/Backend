<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\UpdateRequest;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param UpdateRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, $resource)
    {
        $payload = $resource->updateViaRequest($request);
        return response()->json($payload, 200);
    }
}
