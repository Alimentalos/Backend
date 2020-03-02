<?php

namespace App;

use App\Contracts\Resource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Geofence extends Model implements ReactableContract, Resource
{
    use SpatialTrait;
    use Reactable;

    /**
     * The mass assignment fields of the geofence.
     *
     * @var array
     */
    protected $fillable = [
        'photo_id',
        'user_id',
        'uuid',
        'photo_url',
        'is_public',
    ];

    /**
     * The default location field of geofence.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_FIELD = 'shape';

    /**
     * The spatial fields of the geofence.
     *
     * @var array
     */
    protected $spatialFields = [
        'shape',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_public' => 'boolean',
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
     * The related Geofenceable.
     * @codeCoverageIgnore
     */
    public function geofenceable()
    {
        return $this->morphTo();
    }


    /**
     * The related Devices.
     *
     * @return BelongsToMany
     */
    public function devices()
    {
        return $this->morphedByMany(Device::class, 'geofenceable');
    }

    /**
     * The related Pets.
     *
     * @return BelongsToMany
     */
    public function pets()
    {
        return $this->morphedByMany(Pet::class, 'geofenceable');
    }

    /**
     * The related Users.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'geofenceable');
    }

    /**
     * The related User.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The related Photo
     *
     * @return BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    /**
     * The related Photos
     *
     * @return BelongsToMany
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }

    /**
     * @return HasMany
     */
    public function accesses()
    {
        return $this->hasMany(Access::class, 'geofence_id', 'id');
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
     * Get lazy loaded relationships of Geofence.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user', 'photo'];
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public static function resolveModels(Request $request)
    {
        return $request->user('api')->is_child ? Geofence::with('user', 'photo')->where(
            'user_id',
            $request->user('api')->user_id
        )->orWhere('is_public', true)->latest()->paginate(20) : Geofence::with('user', 'photo')->where(
            'user_id',
            $request->user('api')->id
        )->orWhere('is_public', true)->latest()->paginate(20);
    }
}
