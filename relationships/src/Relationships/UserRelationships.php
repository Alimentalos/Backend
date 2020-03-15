<?php

namespace Demency\Relationships\Relationships;

use App\Device;
use App\Pet;
use App\Photo;
use App\Place;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserRelationships
{
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
     * The user places.
     *
     * @return HasMany
     */
    public function places()
    {
        return $this->hasMany(Place::class,'user_uuid','uuid');
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
     * The user current photo.
     *
     * @return BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class,'photo_uuid','uuid');
    }
}
