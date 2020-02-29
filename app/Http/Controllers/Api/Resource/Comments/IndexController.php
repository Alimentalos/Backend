<?php

namespace App\Http\Controllers\Api\Resource\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Models\Comments\IndexRequest;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request, $resource)
    {
        return response()->json(
            $resource->comments()->with('user')->latest()->paginate(20),
            200
        );
    }
}
