<?php

namespace App\Http\Controllers\Api\Actions;

use App\Action;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Actions\ShowRequest;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ShowRequest $request
     * @param Action $action
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, Action $action)
    {
        return response()->json(
            $action,
            200
        );
    }
}
