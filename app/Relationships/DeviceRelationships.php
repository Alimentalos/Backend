<?php

namespace App\Relationships;

use App\Access;
use App\Geofence;
use App\Group;
use App\Location;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait DeviceRelationships
{
    /**
     * The related Groups.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany(Group::class,'groupable','groupables','groupable_id','group_uuid','uuid','uuid')->withPivot(['is_admin','status','sender_uuid',])->withTimestamps();
    }

    /**
     * The geofences that belongs to the device
     *
     * @return BelongsToMany
     */
    public function geofences()
    {
        return $this->morphToMany(Geofence::class,'geofenceable','geofenceables','geofenceable_id','geofence_uuid','uuid','uuid');
    }

    /**
     * The related Locations.
     *
     * @return MorphMany
     */
    public function locations()
    {
        return $this->morphMany(Location::class,'trackable','trackable_type','trackable_id','uuid');
    }

    /**
     * The user that belongs this device
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_uuid','uuid');
    }

    /**
     * @return MorphMany
     */
    public function accesses()
    {
        return $this->morphMany(Access::class,'accessible','accessible_type','accessible_id','uuid');
    }
}
