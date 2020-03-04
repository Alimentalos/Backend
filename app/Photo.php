<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\PhotoRelationships;
use App\Repositories\PhotoRepository;
use App\Resources\PhotoResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Photo extends Model implements ReactableContract, Resource
{
    use SpatialTrait;
    use Reactable;
    use PhotoResource;
    use PhotoRelationships;


    /**
     * The mass assignment fields of the photo
     *
     * @var array
     */
    protected $fillable = [
        'user_uuid',
        'comment_uuid',
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
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * Update model via request.
     *
     * @param Request $request
     * @return Photo
     */
    public function updateViaRequest(Request $request)
    {
        return PhotoRepository::updatePhotoViaRequest($request, $this);
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
