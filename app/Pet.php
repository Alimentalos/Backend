<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Commentable;
use App\Relationships\Commons\Geofenceable;
use App\Relationships\Commons\Groupable;
use App\Relationships\Commons\HasPhoto;
use App\Relationships\Commons\Photoable;
use App\Relationships\Commons\Trackable;
use App\Repositories\PetsRepository;
use App\Resources\PetResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class Pet extends Authenticatable implements ReactableContract, Resource
{
    use SpatialTrait;
    use Reactable;
    use PetResource;
    use BelongsToUser;
    use HasPhoto;
    use Trackable;
    use Photoable;
    use Commentable;
    use Geofenceable;
    use Groupable;

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
     * Create model via request.
     *
     * @param Request $request
     * @return Pet
     */
    public static function createViaRequest(Request $request)
    {
        return PetsRepository::createPetViaRequest($request);
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
