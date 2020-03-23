<?php

namespace Demency\Relationships\Models;

use Demency\Contracts\CreateFromRequest;
use Demency\Contracts\Monetizer;
use Demency\Contracts\Resource;
use Demency\Contracts\UpdateFromRequest;
use Demency\Relationships\BelongsToUser;
use Demency\Relationships\Commentable;
use Demency\Relationships\HasCoin;
use Demency\Relationships\HasPhoto;
use Demency\Relationships\Photoable;
use Demency\Relationships\Relationships\GroupRelationships;
use Demency\Relationships\Resources\GroupResource;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Group extends Model implements Resource, CreateFromRequest, UpdateFromRequest, Monetizer
{
    use Searchable;
    use GroupResource;
    use GroupRelationships;
    use BelongsToUser;
    use Photoable;
    use Commentable;
    use HasPhoto;
    use HasCoin;

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
     * Get the value used to index the model.
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getScoutKey()
    {
        return $this->uuid;
    }
}
