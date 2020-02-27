<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Token\IndexRequest;
use App\Repositories\LoggerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    /**
     * Show the user api token.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::once($credentials) && !is_null(Auth::user()->email_verified_at)) {
            // Authentication passed...
            LoggerRepository::createAction(Auth::user(), 'success', 'token', $request->only('email'));

            return response()->json([
                'api_token' => Auth::user()->api_token
            ]);
        }
        return response()->json([
            'message' => 'Unauthenticated.'
        ]);
    }
}
