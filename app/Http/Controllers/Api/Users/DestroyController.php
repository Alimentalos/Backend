<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\DestroyRequest;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(DestroyRequest $request, User $user)
    {
        $user->delete();
        return response()->json(
            ['message' => 'Deleted successfully.'],
            200
        );
    }
}
