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
        if (Auth::once($request->only('email', 'password')) && !is_null(Auth::user()->email_verified_at)) {
            // Authentication passed...
            return response()->json(['api_token' => Auth::user()->api_token]);
        }
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}
