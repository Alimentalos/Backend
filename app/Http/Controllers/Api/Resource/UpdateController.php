<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\UpdateRequest;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Update instance.
     *
     * @param UpdateRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, $resource)
    {
        $payload = $resource->updateViaRequest();
        return response()->json($payload, 200);
    }
}
