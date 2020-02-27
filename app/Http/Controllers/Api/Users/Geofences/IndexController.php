<?php

namespace App\Http\Controllers\Api\Users\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Geofences\IndexRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Geofences of User.
     *
     * @param IndexRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, User $user)
    {
        return response()->json(
            $user->geofences()->latest()->paginate(20),
            200
        );
    }
}
