<?php

namespace App;

use App\Repositories\LocationRepository;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\Builder;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pet extends Authenticatable implements ReactableContract
{
    use SpatialTrait;
    use Reactable;

    /**
     * Mass-assignable properties.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'photo_id',
        'api_token',
        'photo_url',
        'uuid',
        'name',
        'description',
        'hair_color',
        'left_eye_color',
        'right_eye_color',
        'size',
        'born_at',
        'is_public',
        'location',
    ];

    /**
     * The default location field of pet.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_FIELD = 'location';

    /**
     * The default location date column.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_DATE_COLUMN = 'created_at';

    /**
     * The default location group by column.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_GROUP_BY_COLUMN = 'id';

    /**
     * The attributes that should be cast to spatial types.
     *
     * @var array
     */
    protected $spatialFields = [
        'location',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_public' => 'boolean',
        'born_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * The related Groups.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany(Group::class, 'groupable')->withPivot([
            'status',
            'sender_id',
        ])->withTimestamps();
    }

    /**
     * The geofences that belong to the pet.
     *
     * @return BelongsToMany
     */
    public function geofences()
    {
        return $this->morphToMany(Geofence::class, 'geofenceable');
    }

    /**
     * @return MorphMany
     */
    public function accesses()
    {
        return $this->morphMany(Access::class, 'accessible');
    }

    /**
     * The related Photo.
     *
     * @return BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    /**
     * The related Photos.
     *
     * @return BelongsToMany
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }

    /**
     * The related Locations.
     *
     * @return MorphMany
     */
    public function locations()
    {
        return $this->morphMany(Location::class, 'trackable');
    }

    /**
     * The User creator.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The related User comments.
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
