<?php

namespace App\Http\Controllers\Api\Users\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Reactions\IndexRequest;
use App\Repositories\LikeRepository;
use App\User;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request, User $user)
    {
        return response()->json(
            LikeRepository::generateFollowStats($user->getLoveReactant(), $request->user('api')->getLoveReacter()),
            200
        );
    }
}
