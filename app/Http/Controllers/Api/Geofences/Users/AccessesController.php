<?php

namespace App\Http\Controllers\Api\Geofences\Users;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\Users\AccessesRequest;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param AccessesRequest $request
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, Geofence $geofence)
    {
        return response()->json(
            $geofence->accesses()->with('accessible', 'first_location', 'last_location', 'geofence')
                ->where('accessible_type', 'App\\User')
                ->where('geofence_id', $geofence->id)
                ->latest()
                ->paginate(20),
            200
        );
    }
}
