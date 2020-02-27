<?php

namespace App\Http\Controllers\Api\Users\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Geofences\AccessesRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * @param AccessesRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, User $user)
    {
        return response()->json(
            $user->accesses()->latest()->with([
                'accessible', 'geofence', 'first_location', 'last_location'
            ])->latest()->paginate(20),
            200
        );
    }
}
