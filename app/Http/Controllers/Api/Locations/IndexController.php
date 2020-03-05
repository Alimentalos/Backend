<?php

namespace App\Http\Controllers\Api\Locations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Locations\IndexRequest;
use App\Http\Resources\LocationCollection;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Retrieve locations of instances.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        $locations = locations()->fetchViaRequest();
        return response()->json(new LocationCollection($locations), 200);
    }
}
