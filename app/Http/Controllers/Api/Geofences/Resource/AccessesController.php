<?php

namespace App\Http\Controllers\Api\Geofences\Resource;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\Resource\AccessesRequest;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param AccessesRequest $request
     * @param Geofence $geofence
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, Geofence $geofence, $resource)
    {
        // TODO - Reduce number of lines of Geofence Resource AccessesController
        // @body move into repository method as fetchResourceViaRequest.
        return response()->json(
            $geofence->accesses()->with('accessible', 'first_location', 'last_location', 'geofence')
                ->where('accessible_type', get_class(binder()::bindResourceModelClass($resource)))
                ->where('geofence_uuid', $geofence->uuid)
                ->latest()
                ->paginate(20),
            200
        );
    }
}
