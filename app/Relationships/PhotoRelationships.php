<?php

namespace App\Relationships;

use App\Alert;
use App\Comment;
use App\Geofence;
use App\Group;
use App\Pet;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait PhotoRelationships
{
    /**
     * Get the owning photoable model.
     */
    public function photoable()
    {
        return $this->morphTo();
    }

    /**
     * The related Photo user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    /**
     * The related Comment.
     * @return BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'user_uuid', 'uuid');
    }

    /**
     * The related Photo comments.
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable','commentable_type','commentable_id','uuid');
    }

    /**
     * The groups that belong to the photo.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->morphedByMany(Group::class,'photoable','photoables','photo_uuid','photoable_id','uuid','uuid');
    }

    /**
     * The users that belong to the photo.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->morphedByMany(User::class,'photoable','photoables','photo_uuid','photoable_id','uuid','uuid');
    }

    /**
     * The alerts that belong to the photo.
     *
     * @return BelongsToMany
     */
    public function alerts()
    {
        return $this->morphedByMany(Alert::class,'photoable','photoables','photo_uuid','photoable_id','uuid','uuid');
    }


    /**
     * The geofences that belong to the photo.
     *
     * @return BelongsToMany
     */
    public function geofences()
    {
        return $this->morphedByMany(Geofence::class,'photoable','photoables','photo_uuid','photoable_id','uuid','uuid');
    }

    /**
     * The related Photo pets.
     *
     * @return BelongsToMany
     */
    public function pets()
    {
        return $this->morphedByMany(Pet::class,'photoable','photoables','photo_uuid','photoable_id','uuid','uuid');
    }
}
