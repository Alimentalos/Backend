<?php

namespace App\Http\Controllers\Api\Users\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Photos\IndexRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, User $user)
    {
        return response()->json(
            $user->photos()->latest()->with('user', 'comment')->paginate(20),
            200
        );
    }
}
