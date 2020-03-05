<?php

namespace App\Http\Controllers\Api\Resource\Geofences\Accesses;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\Accesses\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Retrieve paginated accesses of instance filtering only one geofence.
     *
     * @param IndexRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource, Geofence $geofence)
    {
        $accesses = $resource
            ->accesses()
            ->with(['accessible', 'geofence', 'first_location', 'last_location'])
            ->where([['geofence_uuid', $geofence->uuid]])
            ->latest()
            ->paginate(20);
        return response()->json($accesses,200);
    }
}
