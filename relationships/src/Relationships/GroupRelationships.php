<?php

namespace Alimentalos\Relationships\Relationships;

use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait GroupRelationships
{
    /**
     * The related Groupable.
     * @codeCoverageIgnore
     */
    public function groupable()
    {
        return $this->morphTo('groupable','groupable_type','groupable_id','group_uuid');
    }

    /**
     * The related Users.
     *
     * @return MorphToMany
     */
    public function users()
    {
        return $this->morphedByMany(User::class,'groupable','groupables','group_uuid','groupable_id','uuid','uuid')
            ->withPivot(['is_admin','status','sender_uuid'])->withTimestamps();
    }

    /**
     * The related Devices.
     *
     * @return MorphToMany
     */
    public function devices()
    {
        return $this->morphedByMany(Device::class,'groupable','groupables','group_uuid','groupable_id','uuid','uuid')
            ->withPivot(['is_admin','status','sender_uuid'])->withTimestamps();
    }

    /**
     * The related Pets.
     *
     * @return MorphToMany
     */
    public function pets()
    {
        return $this->morphedByMany(Pet::class,'groupable','groupables','group_uuid','groupable_id','uuid','uuid')
            ->withPivot(['is_admin','status','sender_uuid'])->withTimestamps();
    }

    /**
     * The related Geofences.
     *
     * @return MorphToMany
     */
    public function geofences()
    {
        return $this->morphedByMany(Geofence::class,'groupable','groupables','group_uuid','groupable_id','uuid','uuid')
            ->withPivot(['is_admin','status','sender_uuid']);
    }
}
