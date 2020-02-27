<?php

namespace App\Http\Controllers\Api\Users\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Groups\IndexRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display a list with groups of a user
     *
     * @param IndexRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, User $user)
    {
        return response()->json(
            $user->groups()->with('user', 'photo')->paginate(20),
            200
        );
    }
}
