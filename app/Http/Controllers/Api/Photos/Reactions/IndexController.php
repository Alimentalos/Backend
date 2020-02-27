<?php

namespace App\Http\Controllers\Api\Photos\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\Reactions\IndexRequest;
use App\Photo;
use App\Repositories\LikeRepository;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request, Photo $photo)
    {
        return response()->json(
            LikeRepository::generateStats($photo->getLoveReactant(), $request->user('api')->getLoveReacter()),
            200
        );
    }
}
