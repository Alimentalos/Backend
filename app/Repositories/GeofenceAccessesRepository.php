<?php


namespace App\Repositories;

use App\Geofence;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class GeofenceAccessesRepository
{
    /**
     * Fetch via Geofence resource accesses.
     *
     * @param Request $request
     * @param Geofence $geofence
     * @param $resource
     * @return LengthAwarePaginator
     */
    public static function fetchResourceViaRequest(Request $request, Geofence $geofence, $resource)
    {
        return $geofence->accesses()->with('accessible', 'first_location', 'last_location', 'geofence')
            ->where('accessible_type', get_class(finder('resourceModelClass', $resource)))
            ->where('geofence_uuid', $geofence->uuid)
            ->latest()
            ->paginate(20);
    }
}
