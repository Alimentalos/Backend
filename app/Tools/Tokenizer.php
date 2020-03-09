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
            // TODO Handle token expired exception
            //Do something
            //return $e->getMessage();
        } catch (TokenBlacklistedException $e) {
            // TODO Handle token blacklisted exception
            //Do something
            //return $e->getMessage();
        } catch (\Exception $e) {
            // TODO Handle others exceptions
            //Do something
            //return $e->getMessage();
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
