<?php

namespace Demency\Relationships\Relationships;

use App\Geofence;
use App\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait AccessRelationships
{
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
        return $this->belongsTo(Location::class, 'last_location_uuid', 'uuid');
    }

    /**
     * The related first Location.
     *
     * @return BelongsTo
     */
    public function first_location()
    {
        return $this->belongsTo(Location::class, 'first_location_uuid', 'uuid');
    }

    /**
     * The related Geofence.
     *
     * @return BelongsTo
     */
    public function geofence()
    {
        return $this->belongsTo(Geofence::class, 'geofence_uuid', 'uuid');
    }
}
