<?php

namespace App;

use App\Contracts\Resource;
use App\Repositories\GeofenceRepository;
use App\Repositories\GroupsRepository;
use App\Rules\Coordinate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Group extends Model implements Resource
{
    /**
     * Pending status
     */
    public const PENDING_STATUS = 1;

    /**
     * Rejected status
     */
    public const REJECTED_STATUS = 2;

    /**
     * Accepted status
     */
    public const ACCEPTED_STATUS = 3;

    /**
     * Accepted status
     */
    public const ATTACHED_STATUS = 4;

    /**
     * Accepted status
     */
    public const BLOCKED_STATUS = 5;

    /**
     * The mass assignment fields of the device.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_uuid',
        'photo_uuid',
        'name',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Eager loading properties.
     *
     * @var array
     */
    protected $with = [
        'user'
    ];

    /**
     * Update model via request.
     *
     * @param Request $request
     * @return Group
     */
    public function updateViaRequest(Request $request)
    {
        return GroupsRepository::updateGroupViaRequest($request, $this);
    }

    /**
     * Update geofence validation rules.
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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * The related Groupable.
     *
     * @codeCoverageIgnore
     */
    public function groupable()
    {
        return $this->morphTo(
            'groupable',
            'groupable_type',
            'groupable_id',
            'group_uuid'
        );
    }

    /**
     * The related Users.
     *
     * @return MorphToMany
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'groupable',
            'groupables',
            'group_uuid',
            'groupable_id',
            'uuid',
            'uuid'
        )->withPivot([
            'is_admin',
            'status',
            'sender_uuid'
        ])->withTimestamps();
    }

    /**
     * The related Devices.
     *
     * @return MorphToMany
     */
    public function devices()
    {
        return $this->morphedByMany(Device::class, 'groupable',
            'groupables',
            'group_uuid',
            'groupable_id',
            'uuid',
            'uuid'
        )->withPivot([
            'is_admin',
            'status',
            'sender_uuid'
        ]);
    }

    /**
     * The related Pets.
     *
     * @return MorphToMany
     */
    public function pets()
    {
        return $this->morphedByMany(Pet::class, 'groupable',
            'groupables',
            'group_uuid',
            'groupable_id',
            'uuid',
            'uuid'
        )->withPivot([
            'is_admin',
            'status',
            'sender_uuid'
        ]);
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
     * The related User.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
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
     * The related Comments.
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
     * The related Geofences.
     *
     * @return MorphToMany
     */
    public function geofences()
    {
        return $this->morphedByMany(Geofence::class, 'groupable',
            'groupables',
            'group_uuid',
            'groupable_id',
            'uuid',
            'uuid'
        )->withPivot([
            'is_admin',
            'status',
            'sender_uuid'
        ]);
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
        return (
        $request->user('api')->is_admin ?
            self::with('user', 'photo') :
            self::with('user', 'photo')->where('user_uuid', $request->user('api')->uuid)
        )->latest()->paginate(25);
    }
}
