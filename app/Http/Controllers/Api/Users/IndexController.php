<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\IndexRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        // TODO - Remove unnecessary complexity
        if (!is_null($request->user('api')->user_id)) {
            $users = User::with('photo', 'user')->latest()->where([
                ['user_id', $request->user('api')->user_id]
            ])->orWhere([
                ['id', $request->user('api')->user_id]
            ])->paginate(20);
        } elseif ($request->user('api')->is_admin) {
            $users = User::with('photo', 'user')->latest()->paginate(20);
        } else {
            $users = User::with('photo', 'user')->latest()->where([
                ['user_id', $request->user()->id]
            ])->orWhere([
                ['id', $request->user('api')->id]
            ])->paginate(20);
        }

        return response()->json($users, 200);
    }
}
