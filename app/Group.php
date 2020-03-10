<?php

namespace App;

use App\Contracts\CreateFromRequest;
use App\Contracts\Resource;
use App\Contracts\UpdateFromRequest;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Commentable;
use App\Relationships\Commons\HasPhoto;
use App\Relationships\Commons\Photoable;
use App\Relationships\GroupRelationships;
use App\Resources\GroupResource;
use Illuminate\Database\Eloquent\Model;

class Group extends Model implements Resource, CreateFromRequest, UpdateFromRequest
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
}
