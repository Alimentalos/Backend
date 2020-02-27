<?php

namespace App\Http\Controllers\Api\Geofences\Groups;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\Groups\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display a list with groups of a user
     *
     * @param IndexRequest $request
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Geofence $geofence)
    {
        return response()->json(
            $geofence->groups()->latest()->with('user', 'photo')->paginate(20),
            200
        );
    }
}
