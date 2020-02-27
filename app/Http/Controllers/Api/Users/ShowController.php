<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\ShowRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, User $user)
    {
        $user->load('photo', 'user');

        return response()->json($user, 200);
    }
}
