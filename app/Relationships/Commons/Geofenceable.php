<?php


namespace App\Relationships\Commons;


use App\Geofence;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Geofenceable
{
    /**
     * The resource related geofences.
     *
     * @return MorphToMany
     */
    public function geofences()
    {
        return $this->morphToMany(Geofence::class,'geofenceable','geofenceables','geofenceable_id','geofence_uuid','uuid','uuid');
    }
}
