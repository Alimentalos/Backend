<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Repositories\LoggerRepository;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'is_public' => $request->has('is_public')
        ]);

        event(new Registered($user));

        LoggerRepository::createAction(
            $user,
            'success',
            'register',
            $request->only('name', 'email', 'is_public')
        );

        return response()->json($user, 200);
    }
}
