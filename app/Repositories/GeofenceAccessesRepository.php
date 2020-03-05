<?php


namespace App\Repositories;

use App\Contracts\Resource;
use App\Geofence;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GeofenceAccessesRepository
{
    /**
     * Fetch via Geofence resource accesses.
     *
     * @param Geofence $geofence
     * @param Resource $resource
     * @return LengthAwarePaginator
     */
    public function fetchResourceViaRequest(Geofence $geofence, Resource $resource)
    {
        return $geofence->accesses()->with('accessible', 'first_location', 'last_location', 'geofence')
            ->where('accessible_type', get_class($resource))
            ->where('geofence_uuid', $geofence->uuid)
            ->latest()
            ->paginate(20);
    }
}
