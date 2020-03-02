<?php

namespace App\Http\Controllers\Api\Actions;

use App\Action;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Actions\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param DestroyRequest $request
     * @param Action $action
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, Action $action)
    {
        try {
            $action->delete();

            return response()->json(
                ['message' => 'Deleted successfully.'],
                200
            );
        } catch (Exception $exception) {
            return response()->json(
                ['message' => 'Resource cannot be deleted.'],
                500
            );
        }
    }
}
