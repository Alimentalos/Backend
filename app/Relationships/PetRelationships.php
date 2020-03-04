<?php

namespace App\Relationships;

use App\Access;
use App\Comment;
use App\Geofence;
use App\Group;
use App\Location;
use App\Photo;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait PetRelationships
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
     * The geofences that belong to the pet.
     *
     * @return BelongsToMany
     */
    public function geofences()
    {
        return $this->morphToMany(Geofence::class,'geofenceable','geofenceables','geofenceable_id','geofence_uuid','uuid','uuid');
    }

    /**
     * @return MorphMany
     */
    public function accesses()
    {
        return $this->morphMany(Access::class,'accessible','accessible_type','accessible_id','uuid');
    }

    /**
     * The related Photo.
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
     * The related Locations.
     *
     * @return MorphMany
     */
    public function locations()
    {
        return $this->morphMany(Location::class,'trackable','trackable_type','trackable_id','uuid');
    }

    /**
     * The User creator.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_uuid','uuid');
    }

    /**
     * The related User comments.
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable','commentable_type','commentable_id','uuid');
    }
}
