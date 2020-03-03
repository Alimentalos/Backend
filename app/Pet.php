<?php

namespace App;

use App\Contracts\Resource;
use App\Repositories\CommentsRepository;
use App\Repositories\PetsRepository;
use App\Rules\Coordinate;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Pet extends Authenticatable implements ReactableContract, Resource
{
    use SpatialTrait;
    use Reactable;

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
    public const DEFAULT_LOCATION_GROUP_BY_COLUMN = 'uuid';

    /**
     * Comma-separated accepted values.
     *
     * @var string
     */
    public const AVAILABLE_REACTIONS = 'Love,Pray,Like,Dislike,Sad,Hate';

    /**
     * Mass-assignable properties.
     *
     * @var array
     */
    protected $fillable = [
        'user_uuid',
        'photo_uuid',
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
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * Update model via request.
     *
     * @param Request $request
     * @return Pet
     */
    public function updateViaRequest(Request $request)
    {
        return PetsRepository::updatePetViaRequest($request, $this);
    }

    /**
     * Update pet validation rules.
     *
     * @param Request $request
     * @return array
     */
    public static function updateRules(Request $request)
    {
        return [
            'coordinates' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->has('photo');
                }), new Coordinate()
            ],
        ];
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
     * The geofences that belong to the pet.
     *
     * @return BelongsToMany
     */
    public function geofences()
    {
        return $this->morphToMany(Geofence::class, 'geofenceable',
            'geofenceables',
            'geofenceable_id',
            'geofence_uuid',
            'uuid',
            'uuid'
        );
    }

    /**
     * @return MorphMany
     */
    public function accesses()
    {
        return $this->morphMany(Access::class, 'accessible', 'accessible_type',
            'accessible_id', 'uuid');
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
        return $this->morphToMany(Photo::class, 'photoable',
            'photoables',
            'photoable_id',
            'photo_uuid',
            'uuid',
            'uuid'
        );
    }

    /**
     * The related Locations.
     *
     * @return MorphMany
     */
    public function locations()
    {
        return $this->morphMany(Location::class, 'trackable', 'trackable_type',
            'trackable_id', 'uuid');
    }

    /**
     * The User creator.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    /**
     * The related User comments.
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable',
            'commentable_type',
            'commentable_id',
            'uuid'
        );
    }

    /**
     * Get lazy loaded relationships of Geofence.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['photo', 'user'];
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public static function resolveModels(Request $request)
    {
        return self::with('user', 'photo')->latest()->paginate(20);
    }
}
