<?php

namespace Alimentalos\Relationships\Relationships;

use App\Models\Alert;
use App\Models\Comment;
use App\Models\Geofence;
use App\Models\Group;
use App\Models\Pet;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait PhotoRelationships
{
    /**
     * Get the owning photoable model.
     * @codeCoverageIgnore
     */
    public function photoable()
    {
        return $this->morphTo('photoable', 'photoable_type', 'photoable_id', 'uuid');
    }

    /**
     * The related Comment.
     * @return BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_uuid', 'uuid');
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
     * The alerts that belong to the place.
     *
     * @return BelongsToMany
     */
    public function places()
    {
        return $this->morphedByMany(Place::class,'photoable','photoables','photo_uuid','photoable_id','uuid','uuid');
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
