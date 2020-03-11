<?php

namespace App;

use App\Contracts\CreateFromRequest;
use App\Contracts\Resource;
use App\Contracts\UpdateFromRequest;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Groupable;
use App\Relationships\Commons\HasPhoto;
use App\Relationships\Commons\Photoable;
use App\Relationships\GeofenceRelationships;
use App\Resources\GeofenceResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Geofence extends Model implements ReactableContract, Resource, CreateFromRequest, UpdateFromRequest
{
    use SpatialTrait;
    use Reactable;
    use GeofenceResource;
    use GeofenceRelationships;
    use BelongsToUser;
    use Photoable;
    use Groupable;
    use HasPhoto;

    /**
     * The default location field of geofence.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_FIELD = 'shape';

    /**
     * The mass assignment fields of the geofence.
     *
     * @var array
     */
    protected $fillable = [
        'photo_uuid',
        'user_uuid',
        'uuid',
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
     * The spatial fields of the geofence.
     *
     * @var array
     */
    protected $spatialFields = [
        'shape',
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
     * The properties which are loaded.
     *
     * @var array
     */
    protected $with = ['user', 'photo'];

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
