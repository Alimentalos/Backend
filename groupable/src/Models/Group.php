<?php

namespace Demency\Groupable\Models;

use App\Coin;
use App\Contracts\CreateFromRequest;
use App\Contracts\Monetizer;
use App\Contracts\Resource;
use App\Contracts\UpdateFromRequest;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Commentable;
use App\Relationships\Commons\HasPhoto;
use App\Relationships\Commons\Photoable;
use Demency\Groupable\Relationships\GroupRelationships;
use Demency\Groupable\Resources\GroupResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Group extends Model implements Resource, CreateFromRequest, UpdateFromRequest, Monetizer
{
    use GroupResource;
    use GroupRelationships;
    use BelongsToUser;
    use Photoable;
    use Commentable;
    use HasPhoto;

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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get group coins.
     *
     * @return MorphMany
     */
    public function coins()
    {
        return $this->morphMany(Coin::class,'monetizer','monetizer_type','monetizer_id','uuid');
    }
}
