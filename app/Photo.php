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
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class Photo extends Model implements ReactableContract, Resource
{
    use SpatialTrait;
    use Reactable;

    /**
     * Comma-separated accepted values.
     *
     * @var string
     */
    public const AVAILABLE_REACTIONS = 'Love,Pray,Like,Dislike,Sad,Hate';

    /**
     * The mass assignment fields of the photo
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'comment_id',
        'photo_url',
        'ext',
        'uuid',
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
        return $this->belongsTo(User::class);
    }

    /**
     * The related Comment.
     * @return BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * The related Photo comments.
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * The groups that belong to the photo.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->morphedByMany(Group::class, 'photoable');
    }

    /**
     * The users that belong to the photo.
     *
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'photoable');
    }

    /**
     * The alerts that belong to the photo.
     *
     * @return BelongsToMany
     */
    public function alerts()
    {
        return $this->morphedByMany(Alert::class, 'photoable');
    }


    /**
     * The geofences that belong to the photo.
     *
     * @return BelongsToMany
     */
    public function geofences()
    {
        return $this->morphedByMany(Geofence::class, 'photoable');
    }

    /**
     * The related Photo pets.
     *
     * @return BelongsToMany
     */
    public function pets()
    {
        return $this->morphedByMany(Pet::class, 'photoable');
    }

    /**
     * Get lazy loaded relationships of Geofence.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user'];
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public static function resolveModels(Request $request)
    {
        return self::with('user', 'photoable')->latest()->paginate(20);
    }
}
