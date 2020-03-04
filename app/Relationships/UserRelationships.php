<?php


namespace App\Relationships;


use App\Access;
use App\Device;
use App\Geofence;
use App\Group;
use App\Location;
use App\Pet;
use App\Photo;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait UserRelationships
{
    /**
     * The related Groups.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany(Group::class,'groupable','groupables','groupable_id','group_uuid','uuid','uuid')
            ->withPivot(['is_admin','status','sender_uuid',])->withTimestamps();
    }

    /**
     * The geofences that belongs to the user
     *
     * @return BelongsToMany
     */
    public function geofences()
    {
        return $this->morphToMany(Geofence::class,'geofenceable','geofenceables','geofenceable_id','geofence_uuid','uuid','uuid');
    }

    /**
     * The devices that belongs to the user.
     *
     * @return HasMany
     */
    public function devices()
    {
        return $this->hasMany(Device::class,'user_uuid','uuid');
    }

    /**
     * The user pets.
     *
     * @return HasMany
     */
    public function pets()
    {
        return $this->hasMany(Pet::class,'user_uuid','uuid');
    }

    /**
     * The child users.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class,'user_uuid','uuid');
    }

    /**
     * The user locations.
     *
     * @return MorphMany
     */
    public function locations()
    {
        return $this->morphMany(Location::class,'trackable','trackable_type','trackable_id','uuid');
    }

    /**
     * The owner user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_uuid','uuid');
    }

    /**
     * The user current photo.
     *
     * @return BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class,'photo_uuid','uuid');
    }

    /**
     * The user photos.
     *
     * @return BelongsToMany
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class,'photoable','photoables','photoable_id','photo_uuid','uuid','uuid');
    }

    /**
     * The user accesses.
     *
     * @return MorphMany
     */
    public function accesses()
    {
        return $this->morphMany(Access::class,'accessible','accessible_type','accessible_id','uuid');
    }
}
