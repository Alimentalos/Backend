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
        $credentials = only('email', 'password');
        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
