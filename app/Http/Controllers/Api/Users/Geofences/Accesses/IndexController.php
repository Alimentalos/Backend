<?php

namespace App\Http\Controllers\Api\Users\Geofences\Accesses;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Geofences\Accesses\IndexRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param User $user
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, User $user, Geofence $geofence)
    {
        return response()->json(
            $user->accesses()->latest()->with([
                'accessible', 'geofence', 'first_location', 'last_location'
            ])->where([
                ['geofence_id', $geofence->id]
            ])->latest()->paginate(20),
            200
        );
    }
}
