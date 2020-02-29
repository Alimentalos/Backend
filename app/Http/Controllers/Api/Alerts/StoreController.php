<?php

namespace App\Http\Controllers\Api\Alerts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Alerts\StoreRequest;
use App\Repositories\AlertsRepository;
use App\Repositories\PhotoRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $alert = AlertsRepository::createAlertViaRequest($request, $photo);
        $alert->load('photo', 'user');
        return response()->json(
            $alert,
            201
        );
    }
}
