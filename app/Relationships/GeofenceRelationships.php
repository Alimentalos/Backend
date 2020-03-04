<?php

namespace App\Relationships;

use App\Access;
use App\Device;
use App\Group;
use App\Pet;
use App\Photo;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait GeofenceRelationships
{
    /**
     * The related Geofenceable.
     * @codeCoverageIgnore
     */
    public function geofenceable()
    {
        return $this->morphTo('geofenceable','geofenceable_type','geofenceable_id','geofence_uuid');
    }


    /**
     * The related Devices.
     *
     * @return BelongsToMany
     */
    public function devices()
    {
        return $this->morphedByMany(Device::class,'geofenceable','geofenceables','geofence_uuid','geofenceable_id','uuid','uuid');
    }

    /**
     * The related Pets.
     *
     * @return BelongsToMany
     */
    public function pets()
    {
        return $this->morphedByMany(Pet::class,'geofenceable','geofenceables','geofence_uuid','geofenceable_id','uuid','uuid');
    }

    /**
     * The related Users.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->morphedByMany(User::class,'geofenceable','geofenceables','geofence_uuid','geofenceable_id','uuid','uuid');
    }

    /**
     * The related User.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'photo_uuid', 'uuid');
    }

    /**
     * The related Photo
     *
     * @return BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_uuid', 'uuid');
    }

    /**
     * The related Photos.
     *
     * @return BelongsToMany
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class,'photoable','photoables','photoable_id','photo_uuid','uuid','uuid');
    }

    /**
     * @return HasMany
     */
    public function accesses()
    {
        return $this->hasMany(Access::class, 'geofence_uuid', 'uuid');
    }

    /**
     * The related Groups.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany(Group::class,'groupable','groupables','groupable_id','group_uuid','uuid','uuid')
            ->withPivot(['is_admin','status','sender_uuid'])->withTimestamps();
    }
}
