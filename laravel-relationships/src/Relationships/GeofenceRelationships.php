<?php

namespace Demency\Relationships\Relationships;

use Demency\Relationships\Models\Access;
use Demency\Relationships\Models\Device;
use Demency\Relationships\Models\Pet;
use Demency\Relationships\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait GeofenceRelationships
{
    /**
     * The related geofenceable resource.
     * @codeCoverageIgnore
     */
    public function geofenceable()
    {
        return $this->morphTo('geofenceable','geofenceable_type','geofenceable_id','geofence_uuid');
    }

    /**
     * The related geofence devices.
     *
     * @return BelongsToMany
     */
    public function devices()
    {
        return $this->morphedByMany(Device::class,'geofenceable','geofenceables','geofence_uuid','geofenceable_id','uuid','uuid');
    }

    /**
     * The related geofence pets.
     *
     * @return BelongsToMany
     */
    public function pets()
    {
        return $this->morphedByMany(Pet::class,'geofenceable','geofenceables','geofence_uuid','geofenceable_id','uuid','uuid');
    }

    /**
     * The related geofence users.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->morphedByMany(User::class,'geofenceable','geofenceables','geofence_uuid','geofenceable_id','uuid','uuid');
    }

    /**
     * The related geofence accesses.
     *
     * @return HasMany
     */
    public function accesses()
    {
        return $this->hasMany(Access::class, 'geofence_uuid', 'uuid');
    }
}
