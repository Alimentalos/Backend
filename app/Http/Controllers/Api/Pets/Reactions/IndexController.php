<?php

namespace App\Http\Controllers\Api\Pets\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Reactions\IndexRequest;
use App\Pet;
use App\Repositories\LikeRepository;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request, Pet $pet)
    {
        return response()->json(
            LikeRepository::generateStats($pet->getLoveReactant(), $request->user('api')->getLoveReacter()),
            200
        );
    }
}
