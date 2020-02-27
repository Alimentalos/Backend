<?php

namespace App\Http\Controllers\Api\Geofences\Reactions;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\Reactions\StoreRequest;
use App\Repositories\LikeRepository;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, Geofence $geofence)
    {
        LikeRepository::updateLike(
            $geofence->getLoveReactant(),
            $request->user('api')->getLoveReacter(),
            $request->input('type')
        );
        return response()->json(
            [],
            200
        );
    }
}
