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
     * The user current photo.
     *
     * @return BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class,'photo_uuid','uuid');
    }
}
