<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRecoveryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

class PasswordRecoveryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param PasswordRecoveryRequest $request
     * @return JsonResponse
     */
    public function __invoke(PasswordRecoveryRequest $request)
    {
        Password::broker()->sendResetLink($request->only('email'));
        return response()->json([],200);
    }
}
