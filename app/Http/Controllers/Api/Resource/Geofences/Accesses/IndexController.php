<?php

namespace App\Http\Controllers\Api\Resource\Geofences\Accesses;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\Accesses\IndexRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Geofences of Resource.
     *
     * @param IndexRequest $request
     * @param $resource
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource, Geofence $geofence)
    {
        return response()->json(
            $resource->accesses()->with([
                'accessible', 'geofence', 'first_location', 'last_location'
            ])->where([
                ['geofence_id', $geofence->id]
            ])->latest()->paginate(20),
            200
        );
    }
}
