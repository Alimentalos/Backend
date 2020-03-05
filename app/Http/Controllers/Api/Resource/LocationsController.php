<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizedRequest;
use Illuminate\Http\JsonResponse;

class LocationsController extends Controller
{
    /**
     * Store instance location.
     *
     * @param AuthorizedRequest $request
     * @return JsonResponse
     */
    public function __invoke(AuthorizedRequest $request)
    {
        $locations = resourceLocations()->createViaRequest();
        return response()->json($locations,201);
    }
}
