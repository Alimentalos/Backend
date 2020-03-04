<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Commentable;
use App\Relationships\Commons\HasPhoto;
use App\Relationships\Commons\Photoable;
use App\Relationships\GroupRelationships;
use App\Repositories\GroupsRepository;
use App\Resources\GroupResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Group extends Model implements Resource
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
     * Create model via request.
     *
     * @param Request $request
     * @return Group
     */
    public function createViaRequest(Request $request)
    {
        return GroupsRepository::createGroupViaRequest($request);
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
}
