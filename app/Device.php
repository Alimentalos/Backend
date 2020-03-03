<?php

namespace App;

use App\Contracts\Resource;
use App\Http\Resources\DeviceCollection;
use App\Repositories\AlertsRepository;
use App\Repositories\DevicesRepository;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
     * Update device validation rules.
     *
     * @param Request $request
     * @return array
     */
    public static function updateRules(Request $request)
    {
        return [];
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
     * Store device validation rules.
     *
     * @param Request $request
     * @return array
     */
    public static function storeRules(Request $request)
    {
        return [
            'name' => 'required',
            'is_public' => 'required|boolean',
        ];
    }

    /**
     * The related Groups.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->morphToMany(
            Group::class,
            'groupable',
            'groupables',
            'groupable_id',
            'group_uuid',
            'uuid',
            'uuid'
        )->withPivot([
            'is_admin',
            'status',
            'sender_uuid',
        ])->withTimestamps();
    }

    /**
     * The geofences that belongs to the device
     *
     * @return BelongsToMany
     */
    public function geofences()
    {
        return $this->morphToMany(Geofence::class, 'geofenceable',
            'geofenceables',
            'geofenceable_id',
            'geofence_uuid',
            'uuid',
            'uuid'
        );
    }

    /**
     * The related Locations.
     *
     * @return MorphMany
     */
    public function locations()
    {
        return $this->morphMany(Location::class, 'trackable', 'trackable_type',
            'trackable_id', 'uuid');
    }

    /**
     * The user that belongs this device
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    /**
     * @return MorphMany
     */
    public function accesses()
    {
        return $this->morphMany(Access::class, 'accessible', 'accessible_type',
            'accessible_id', 'uuid');
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
