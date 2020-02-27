<?php

namespace App\Http\Controllers\Api\Geofences\Reactions;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\Reactions\IndexRequest;
use App\Repositories\LikeRepository;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request, Geofence $geofence)
    {
        return response()->json(
            LikeRepository::generateFollowStats($geofence->getLoveReactant(), $request->user('api')->getLoveReacter()),
            200
        );
    }
}
