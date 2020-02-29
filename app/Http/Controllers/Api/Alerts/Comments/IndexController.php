<?php

namespace App\Http\Controllers\Api\Alerts\Comments;

use App\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Models\Comments\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param Alert $alert
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Alert $alert)
    {
        return response()->json(
            $alert->comments()->latest()->with('user')->latest()->paginate(20),
            200
        );
    }
}
