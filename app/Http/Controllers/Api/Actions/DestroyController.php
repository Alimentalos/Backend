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
     * @throws Exception
     */
    public function __invoke(DestroyRequest $request, Action $action)
    {
        $action->delete();

        // TODO - Refactor using constant
        return response()->json(
            ['message' => 'Deleted successfully.'],
            200
        );
    }
}
