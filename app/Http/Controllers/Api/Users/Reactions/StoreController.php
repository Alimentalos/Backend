<?php

namespace App\Http\Controllers\Api\Users\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Reactions\StoreRequest;
use App\Repositories\LikeRepository;
use App\User;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, User $user)
    {
        LikeRepository::updateLike(
            $user->getLoveReactant(),
            $request->user('api')->getLoveReacter(),
            $request->input('type')
        );
        return response()->json(
            [],
            200
        );
    }
}
