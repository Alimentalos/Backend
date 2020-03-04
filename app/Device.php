<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Geofenceable;
use App\Relationships\Commons\Groupable;
use App\Relationships\Commons\Trackable;
use App\Repositories\DevicesRepository;
use App\Resources\DeviceResource;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

/**
 * Class Device
 *
 * @package App
 * @author Ian Torres
 * @license MIT
 */
class Device extends Authenticatable implements Resource
{
    use SpatialTrait;
    use DeviceResource;
    use Groupable;
    use Geofenceable;
    use BelongsToUser;
    use Trackable;

    /**
     * The mass assignment fields of the device
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_uuid',
        'name',
        'description',
        'api_token',
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
     * The default location field of device.
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
     * Update model via request.
     *
     * @param Request $request
     * @return Http\Resources\Device
     */
    public function updateViaRequest(Request $request)
    {
        return DevicesRepository::updateDeviceViaRequest($request, $this);
    }

    /**
     * @param Request $request
     * @return Http\Resources\Device
     */
    public static function createViaRequest(Request $request)
    {
        return DevicesRepository::createDeviceViaRequest($request);
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
        $devices = DevicesRepository::fetchInDatabaseDevicesQuery();

        return $devices->latest()->paginate(10);
    }
}
