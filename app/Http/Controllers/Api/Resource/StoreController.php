<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\StoreRequest;
use App\Repositories\HandleBindingRepository;
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
        $class = HandleBindingRepository::bindResourceModelClass($request->route('resource'));
        $obj = $class::createViaRequest($request);
        return response()
            ->json(
                $obj,
                201
            );
    }
}
