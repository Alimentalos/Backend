<?php

namespace App\Http\Controllers\Api\Alerts;

use App\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Alerts\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        $alerts = Alert::query()->paginate(25);
        return response()->json($alerts, 200);
    }
}
