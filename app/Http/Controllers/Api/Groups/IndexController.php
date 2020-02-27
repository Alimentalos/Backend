<?php

namespace App\Http\Controllers\Api\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\IndexRequest;
use App\Http\Resources\GroupCollection;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return GroupCollection
     */
    public function __invoke(IndexRequest $request)
    {
        // TODO - Remove unnecessary complexity
        $groups = $request->user('api')->is_admin ?
            Group::all() :
            Group::where('user_id', $request->user('api')->id)->latest()->get();

        return new GroupCollection($groups);
    }
}
