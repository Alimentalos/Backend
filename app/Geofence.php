<?php

namespace App;

use App\Contracts\Resource;
use App\Repositories\GeofenceRepository;
use App\Resources\GeofenceResource;
use App\Rules\Coordinate;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Geofence extends Model implements ReactableContract, Resource
{
    use SpatialTrait;
    use Reactable;
    use GeofenceResource;

    /**
     * The default location field of geofence.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_FIELD = 'shape';

    /**
     * The mass assignment fields of the geofence.
     *
     * @var array
     */
    protected $fillable = [
        'photo_uuid',
        'user_uuid',
        'uuid',
        'photo_url',
        'is_public',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

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
     * Update model via request.
     *
     * @param Request $request
     * @return Geofence
     */
    public function updateViaRequest(Request $request)
    {
        return GeofenceRepository::updateGeofenceViaRequest($request, $this);
    }

    /**
     * Create model via request.
     *
     * @param Request $request
     * @return Geofence
     */
    public static function createViaRequest(Request $request)
    {
        return GeofenceRepository::createGeofenceViaRequest($request);
    }

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
        return $this->morphTo(
            'geofenceable',
            'geofenceable_type',
            'geofenceable_id',
            'geofence_uuid'
        );
    }


    /**
     * The related Devices.
     *
     * @return BelongsToMany
     */
    public function devices()
    {
        return $this->morphedByMany(Device::class,
            'geofenceable',
            'geofenceables',
            'geofence_uuid',
            'geofenceable_id',
            'uuid',
            'uuid'
        );
    }

    /**
     * The related Pets.
     *
     * @return BelongsToMany
     */
    public function pets()
    {
        return $this->morphedByMany(Pet::class,
            'geofenceable',
            'geofenceables',
            'geofence_uuid',
            'geofenceable_id',
            'uuid',
            'uuid'
        );
    }

    /**
     * The related Users.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->morphedByMany(User::class,
            'geofenceable',
            'geofenceables',
            'geofence_uuid',
            'geofenceable_id',
            'uuid',
            'uuid'
        );
    }

    /**
     * The related User.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'photo_uuid', 'uuid');
    }

    /**
     * The related Photo
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
        return $this->morphToMany(Photo::class, 'photoable',
            'photoables',
            'photoable_id',
            'photo_uuid',
            'uuid',
            'uuid'
        );
    }

    /**
     * @return HasMany
     */
    public function accesses()
    {
        return $this->hasMany(Access::class, 'geofence_uuid', 'uuid');
    }

    /**
     * The related Groups.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany(
            Group::class,
            'groupable',
            'groupables',
            'groupable_id',
            'group_uuid',
            'uuid',
            'uuid'
        )->withPivot([
            'is_admin',
            'status',
            'sender_uuid',
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
            'user_uuid',
            $request->user('api')->user_uuid
        )->orWhere('is_public', true)->latest()->paginate(20) : Geofence::with('user', 'photo')->where(
            'user_uuid',
            $request->user('api')->uuid
        )->orWhere('is_public', true)->latest()->paginate(20);
    }
}
