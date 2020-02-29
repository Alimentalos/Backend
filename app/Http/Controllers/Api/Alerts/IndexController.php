<?php

namespace App\Http\Controllers\Api\Alerts;

use App\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Alerts\IndexRequest;
use App\Repositories\StatusRepository;
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
        $alerts = Alert::query()
            ->with('user', 'photo', 'alert')
            ->whereIn(
                'status',
                $request->has('whereInStatus') ?
                    explode(',', $request->input('whereInStatus')) : StatusRepository::availableAlertStatuses() // Filter by statuses
            )->latest('created_at')->paginate(25); // Order by latest
        return response()->json($alerts, 200);
    }
}
