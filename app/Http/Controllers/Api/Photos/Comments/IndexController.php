<?php

namespace App\Http\Controllers\Api\Photos\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\Comments\IndexRequest;
use App\Photo;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param Photo $photo
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Photo $photo)
    {
        return response()->json(
            $photo->comments()->latest()->with('user')->latest()->paginate(20),
            200
        );
    }
}
