<?php

namespace App\Http\Controllers\Api\Locations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Locations\ShowRequest;
use App\Location;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ShowRequest $request
     * @param Location $location
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, Location $location)
    {
        $location->load('trackable');
        return response()->json(
            $location,
            200
        );
    }
}
