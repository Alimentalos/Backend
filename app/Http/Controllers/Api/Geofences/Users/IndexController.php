<?php

namespace App\Http\Controllers\Api\Geofences\Users;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\Users\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param IndexRequest $request
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Geofence $geofence)
    {
        return response()->json(
            $geofence->users()->paginate(20),
            200
        );
    }
}
