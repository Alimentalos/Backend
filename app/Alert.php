<?php

namespace App;

use App\Contracts\Resource;
use App\Repositories\StatusRepository;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

class Alert extends Model implements Resource
{
    use SpatialTrait;

    /**
     * The table name of alert.
     *
     * @var string
     */
    protected $table = 'alerts';

    /**
     * The mass assignment fields of alert.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'photo_uuid',
        'user_uuid',
        'alert_id',
        'alert_type',
        'photo_url',
        'type',
        'location',
        'title',
        'body',
        'status',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * The attributes that should be cast to spatial types.
     *
     * @var array
     */
    protected $spatialFields = [
        'location',
    ];

    /**
     * Get the route key for the alert.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get all of the owning alert models.
     */
    public function alert()
    {
        return $this->morphTo();
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
            'photo_uuid',
            'photoable_id',
            'uuid',
            'uuid'
        );
    }

    /**
     * Get lazy loaded relationships of Alert.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user', 'photo', 'alert'];
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public static function resolveModels(Request $request)
    {
        return Alert::query()
            ->with('user', 'photo', 'alert')
            ->whereIn(
                'status',
                $request->has('whereInStatus') ?
                    explode(',', $request->input('whereInStatus')) : StatusRepository::availableAlertStatuses() // Filter by statuses
            )->latest('created_at')->paginate(25); // Order by latest
    }
}
