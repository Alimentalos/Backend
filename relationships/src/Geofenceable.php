<?php

namespace Demency\Relationships;

use Demency\Relationships\Models\Geofence;
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
