<?php


namespace App\Tools;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class Tokenizer
{
    /**
     * Handle token retrieve attempt.
     *
     * @return JsonResponse
     */
    public function handle()
    {
        if (Auth::once(only('email', 'password')) && !is_null(Auth::user()->email_verified_at)) {
            // Authentication passed...
            return response()->json(['api_token' => Auth::user()->api_token]);
        }
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}
