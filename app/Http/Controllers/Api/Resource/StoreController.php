<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        return response()->json(finder('resourceModelClass', $request->route('resource'))::createViaRequest($request),201);
    }
}
