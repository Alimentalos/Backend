<?php


namespace App\Lists;


use Demency\Contracts\Resource;
use App\Geofence;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait GeofenceAccessesList
{
    /**
     * Get geofences.
     *
     * @param Geofence $geofence
     * @param Resource $resource
     * @return LengthAwarePaginator
     */
    public function index(Geofence $geofence, Resource $resource)
    {
        return $geofence->accesses()
            ->where('accessible_type', get_class($resource))
            ->where('geofence_uuid', $geofence->uuid)
            ->latest()
            ->paginate(20);
    }
}
