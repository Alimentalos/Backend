<?php

namespace App\Http\Controllers\Api\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\StoreRequest;
use App\Repositories\GeofenceRepository;
use App\Repositories\PhotoRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $geofence = GeofenceRepository::createGeofenceViaRequest($request, $photo);
        $geofence->load('photo', 'user');
        $photo->geofences()->attach($geofence->id);
        return response()->json(
            $geofence,
            200
        );
    }
}
