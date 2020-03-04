<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\GroupRelationships;
use App\Repositories\GroupsRepository;
use App\Resources\GroupResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Group extends Model implements Resource
{
    use GroupResource;
    use GroupRelationships;

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
    public static function createViaRequest(Request $request)
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
