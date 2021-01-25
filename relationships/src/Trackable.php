<?php

namespace Alimentalos\Relationships;

use App\Models\Access;
use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Trackable
{
    /**
     * The resource related locations.
     *
     * @return MorphMany
     */
    public function locations()
    {
        return $this->morphMany(Location::class,'trackable','trackable_type','trackable_id','uuid');
    }

    /**
     * The resource related accesses.
     *
     * @return MorphMany
     */
    public function accesses()
    {
        return $this->morphMany(Access::class,'accessible','accessible_type','accessible_id','uuid');
    }
}
