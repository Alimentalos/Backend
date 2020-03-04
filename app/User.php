<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\UserRelationships;
use App\Repositories\AdminRepository;
use App\Repositories\UsersRepository;
use App\Resources\UserResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Contracts\Love\Reacterable\Models\Reacterable as ReacterableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail, ReacterableContract, ReactableContract, Resource
{
    use SpatialTrait;
    use Notifiable;
    use Reacterable;
    use Reactable;
    use UserResource;
    use UserRelationships;

    /**
     * The default location field of user.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_FIELD = 'location';

    /**
     * The default location date column.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_DATE_COLUMN = 'generated_at';

    /**
     * The default location group by column.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_GROUP_BY_COLUMN = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'email_verified_at',
        'api_token',
        'photo_uuid',
        'photo_url',
        'user_uuid',
        'name',
        'email',
        'password',
        'free',
        'is_public',
        'location',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
        'api_token',
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
     * Eager loading properties
     *
     * @var array
     */
    protected $with = [
        'user',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
        'free' => 'boolean',
        'is_public' => 'boolean',
    ];

    /**
     * The attributes that will be append.
     *
     * @var array
     */
    protected $appends = [
        'is_admin',
        'is_child'
    ];

    /**
     * Get is_admin custom attribute
     *
     * @return bool
     */
    public function getIsAdminAttribute()
    {
        return AdminRepository::isAdmin($this);
    }

    /**
     * Get is_child custom attribute.
     *
     * @return bool
     */
    public function getIsChildAttribute()
    {
        return !is_null($this->user_uuid);
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
     * Update model via request.
     *
     * @param Request $request
     * @return User
     */
    public function updateViaRequest(Request $request)
    {
        return UsersRepository::updateUserViaRequest($request, $this);
    }

    /**
     * Create model via request.
     *
     * @param Request $request
     * @return User
     */
    public static function createViaRequest(Request $request)
    {
        return UsersRepository::createUserViaRequest($request);
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
        if (!is_null($request->user('api')->user_uuid)) {
            return self::with('photo', 'user')->latest()->where([
                ['user_uuid', $request->user('api')->user_uuid]
            ])->orWhere([
                ['uuid', $request->user('api')->user_uuid]
            ])->paginate(20);
        } elseif ($request->user('api')->is_admin) {
            return self::with('photo', 'user')->latest()->paginate(20);
        } else {
            return self::with('photo', 'user')->latest()->where([
                ['user_uuid', $request->user()->uuid]
            ])->orWhere([
                ['uuid', $request->user('api')->uuid]
            ])->paginate(20);
        }
    }
}
