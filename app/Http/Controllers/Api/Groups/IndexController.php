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
        $groups = (
            $request->user('api')->is_admin ?
                Group::with('user', 'photo') :
                Group::with('user', 'photo')->where('user_id', $request->user('api')->id)
        )->latest()->paginate(25);

        return new GroupCollection($groups);
    }
}
