<?php

namespace App\Http\Controllers\Api\Alerts;

use App\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Alerts\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param DestroyRequest $request
     * @param Alert $alert
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(DestroyRequest $request, Alert $alert)
    {
        $alert->delete();
        return response()->json(
            ['message' => 'Deleted successfully.'],
            200
        );
    }
}
