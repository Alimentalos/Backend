<?php

namespace App\Http\Controllers\Api\Users\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Geofences\AttachRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * Attach User in Geofence.
     *
     * @param AttachRequest $request
     * @param User $user
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, User $user, Geofence $geofence)
    {
        $user->geofences()->attach($geofence->id);
        return response()->json([], 200);
    }
}
