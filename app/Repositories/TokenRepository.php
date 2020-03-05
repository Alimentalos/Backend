<?php


namespace App\Repositories;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TokenRepository
{
    /**
     * @return JsonResponse
     */
    public static function handleAuthentication()
    {
        if (Auth::once(only('email', 'password')) && !is_null(Auth::user()->email_verified_at)) {
            // Authentication passed...
            return response()->json(['api_token' => Auth::user()->api_token]);
        }
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}
