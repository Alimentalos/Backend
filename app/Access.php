<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Access extends Model
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'accesses';

    /**
     * Mass-assignable properties.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'accessible_id',
        'accessible_type',
        'geofence_id',
        'first_location_id',
        'last_location_id',
        'status',
    ];

    /**
     * Eager loading properties.
     *
     * @var array
     */
    protected $with = [
        'accessible',
        'geofence',
        'first_location',
        'last_location',
    ];



    /**
     * Get all of the owning commentable models.
     */
    public function accessible()
    {
        return $this->morphTo();
    }

    /**
     * The related last Location
     *
     * @return BelongsTo
     */
    public function last_location()
    {
        return $this->belongsTo(Location::class, 'last_location_id', 'id');
    }

    /**
     * The related first Location.
     *
     * @return BelongsTo
     */
    public function first_location()
    {
        return $this->belongsTo(Location::class, 'first_location_id', 'id');
    }

    /**
     * The related Geofence.
     *
     * @return BelongsTo
     */
    public function geofence()
    {
        return $this->belongsTo(Geofence::class);
    }
}
