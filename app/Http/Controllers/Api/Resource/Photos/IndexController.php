<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Photos\IndexRequest;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request, $resource)
    {
        return response()->json(
            $resource->photos()->latest()->with('user', 'comment')->paginate(20),
            200
        );
    }
}
