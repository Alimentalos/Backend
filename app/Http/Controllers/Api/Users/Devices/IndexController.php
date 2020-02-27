<?php

namespace App\Http\Controllers\Api\Users\Devices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Devices\IndexRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display a list with devices of a user
     *
     * @param IndexRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, User $user)
    {
        return response()->json(
            $user->devices()->latest()->paginate(20),
            200
        );
    }
}
