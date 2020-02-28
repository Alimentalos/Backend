<?php

namespace App\Http\Controllers\Api\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\UpdateRequest;
use App\Repositories\GeofenceRepository;
use App\Repositories\UploadRepository;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * @param UpdateRequest $request
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Geofence $geofence)
    {
        UploadRepository::checkPhotoForUpload($request, $geofence);
        GeofenceRepository::updateGeofenceViaRequest($request, $geofence);
        $geofence->load('photo', 'user');
        return response()->json(
            $geofence,
            200
        );
    }
}
