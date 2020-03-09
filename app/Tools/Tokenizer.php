<?php


namespace App\Tools;


use App\User;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

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
        if (!auth('api')->validate($credentials)) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $token = \JWTAuth::fromUser( User::where('email', input('email'))->first() );
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * Handle refresh token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        try {
            $token = auth('api')->refresh();
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]);
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'Token expired.'], 401);
        } catch (TokenBlacklistedException $e) {
            return response()->json(['message' => 'Token blacklisted.'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token not found.'], 404);
        }
    }

    /**
     * Handle invalidate current token.
     */
    public function logout()
    {
        auth('api')->invalidate();
    }
}
