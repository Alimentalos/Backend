<?php


namespace App\Repositories;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenRepository
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public static function handleAuthentication(Request $request)
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
