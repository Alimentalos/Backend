<?php

namespace App\Http\Controllers\Api\Geofences\Pets;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\Pets\AccessesRequest;
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
            $geofence->accesses()->latest()->with('accessible', 'first_location', 'last_location', 'geofence')
                ->where('accessible_type', 'App\\Pet')
                ->where('geofence_id', $geofence->id)
                ->latest()
                ->paginate(20),
            200
        );
    }
}
