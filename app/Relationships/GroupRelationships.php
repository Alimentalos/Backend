<?php


namespace App\Relationships;

use App\Comment;
use App\Device;
use App\Geofence;
use App\Pet;
use App\Photo;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait GroupRelationships
{
    /**
     * The related Groupable.
     *
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
