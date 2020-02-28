<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\StoreRequest;
use App\Repositories\PhotoRepository;
use App\Repositories\UsersRepository;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $user = UsersRepository::createUserViaRequest($request, $photo);
        $user->load('photo', 'user');
        return response()->json($user, 200);
    }
}
