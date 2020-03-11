<?php


namespace App\Lists;


use App\Geofence;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait GeofenceList
{
    /**
     * Get owner geofences.
     *
     * @return LengthAwarePaginator
     */
    public function getOwnerGeofences()
    {
        return Geofence::where('user_uuid', authenticated()->uuid)
            ->orWhere('is_public', true)
            ->latest()
            ->paginate(20);
    }

    /**
     * Get child geofences.
     *
     * @return LengthAwarePaginator
     */
    public function getChildGeofences()
    {
        return Geofence::where('user_uuid', authenticated()->user_uuid)
            ->orWhere('is_public', true)
            ->latest()
            ->paginate(20);
    }
}
