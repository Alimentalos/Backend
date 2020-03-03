<?php

namespace App;

use App\Contracts\Resource;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Location extends Model implements Resource
{
    use SpatialTrait;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "trackable_uuid",
        "trackable_type",
        "device",
        "uuid",
        "location",
        "accuracy",
        "altitude",
        "speed",
        "heading",
        "odometer",
        "event",
        "activity_type",
        "activity_confidence",
        "battery_level",
        "battery_is_charging",
        "is_moving",
        "generated_at",
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
        'device' => 'array',
        'generated_at' => 'datetime',
    ];

    /**
     * Get all of the owning trackable models.
     */
    public function trackable()
    {
        return $this->morphTo();
    }

    /**
     * The related Device.
     *
     * @return BelongsTo
     * @codeCoverageIgnore // Used on Nova, not coverage required
     */
    public function getEmitterDeviceAttribute()
    {
        return $this->belongsTo(Device::class, 'device_uuid', 'uuid');
    }

    /**
     * Get lazy loaded relationships of Geofence.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['trackable'];
    }

    /**
     * @param Request $request
     * @return Collection
     * @codeCoverageIgnore
     */
    public static function resolveModels(Request $request)
    {
        return self::query()->get();
    }
}
